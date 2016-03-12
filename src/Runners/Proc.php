<?php

namespace AdamBrett\ShellWrapper\Runners;

use AdamBrett\ShellWrapper\Command\CommandInterface;

/**
 * Allows running a command using PHP's proc_open(). This is the single most
 * flexible way of running a command. It is also the only way that allows obtaining
 * the exit code, the standard output, and the error output of a process.
 * In fact, it potentially allows obtaining any information about the process,
 * any of its output, as well as giving input, setting the environment and the
 * working directory for a process.
 *
 * @link https://gist.github.com/drslump/420268#file-command-php Adapted from here
 * @see proc_open()
 */
class Proc implements Runner, ReturnValue
{

    const STDIN = 0;
    const STDOUT = 1;
    const STDERR = 2;
    // Maximum number of bytes to read at once
    const READ_BUFFER_MAX = 4096;
    // Maximum number of milliseconds to sleep while pooling for data
    const SLEEP_MAX = 200;
    // Number of milliseconds to sleep the first time
    const SLEEP_START = 1;
    // Multiplying rate to increase the number of milliseconds to sleep
    const SLEEP_FACTOR = 1.5;

    protected $_returnValue;
    protected $_cwd;
    protected $_env;
    protected $_callback;
    protected $_conf = array();
    protected $_stdin;
    protected $_stdout;
    protected $_stderr;

    /**
     * Runs the command using proc_open(), and the set options.
     *
     * @see setDirectory()
     * @see setEnv()
     * @see setConf()
     * @see setCallback()
     * @param CommandInterface $command
     * @return int|null
     */
    public function run(CommandInterface $command)
    {
        $this->reset();

        return $this->exec(
            (string)$command,
            $this->getBuffers(),
            $this->getCallback(),
            $this->getDirectory(),
            $this->getEnv(),
            $this->getConf()
        );
    }

    /**
     *
     * @return int|null The exit code if the process after it runs.
     *  If code cannot be determined, this will be null.
     */
    public function getReturnValue()
    {
        return $this->_returnValue;
    }

    /**
     * Resets run-specific data for this object.
     *
     * @return \AdamBrett\ShellWrapper\Runners\Proc This instance.
     */
    public function reset()
    {
        $this->_exitcode = null;
        $this->_stdout = null;
        $this->_stderr = null;
        $this->_returnValue = null;

        return $this;
    }

    /**
     * Get the input/output buffers for the process, by channel ID.
     *
     * @return array An array of buffers for input/output. The input buffer
     *  will contain the input to the process. The output buffers will contain
     *  process output when the process is run.
     */
    public function getBuffers()
    {
        return array(
            self::STDIN => $this->getStandardInput(),
            self::STDOUT => &$this->_stdout,
            self::STDERR => &$this->_stderr,
        );
    }

    /**
     * Get the descriptors of process input/output channels, by channel ID.
     *
     * @return array An array of resource descriptors for the process.
     *  Typically, the stdin, stdout and stderr pipes.
     */
    public function getDescriptors()
    {
        return array(
            self::STDIN     => array('pipe', 'r'),
            self::STDOUT    => array('pipe', 'w'),
            self::STDERR    => array('pipe', 'w'),
        );
    }

    /**
     * Register a callback function to be triggered when there is data for stdout/stderr
     *
     * The first argument is the pipe identifier (Command::STDOUT or Command::STDERR)
     * The second argument is either a string with the available data or null to
     * indicate the eof.
     *
     * @param callback $callback
     * @return Proc This instance.
     */
    public function setCallback($callback)
    {
        $this->_callback = $callback;
        return $this;
    }

    /**
     * Gets the callback that will be run when data is read from a pipe.
     *
     * @see setCallback()
     * @return callable|null The callback.
     */
    public function getCallback()
    {
        return $this->_callback;
    }

    /**
     * Sets working directory for the process.
     *
     * @param string|null $cwd The path to the working directory.
     *  If null, the default working directory will be used - the directory of the current PHP process.
     * @return Proc This instance.
     */
    public function setDirectory($cwd)
    {
        $this->_cwd = $cwd;
        return $this;
    }

    /**
     * Get the working directory of the process.
     *
     * @return string|null The path to the working directory, in which the process will run.
     */
    public function getDirectory()
    {
        return $this->_cwd;
    }

    /**
     * Sets environment variables for the command execution
     *
     * @param array|string|null $key The name of the variable for which to set the value,
     *  or an array with such variables and their values.
     *  If null, the same environment as the current PHP process will be used,
     * @param null|mixed $value The value to set to the environmental variable.
     * @return Proc This instance.
     */
    public function setEnv($key, $value = null)
    {
        if (is_array($key) || is_null($key)) {
            $this->_env = $key;
            return $this;
        }

        $this->_env[(string)$key] = (string)$value;
        return $this;
    }

    /**
     * Gets all or one environmental variable set fot the process.
     *
     * @param string $key The name of the environmental variable to get the value of.
     * @param null|mixed $default What to return if key not found.
     * @return array|string|null|mixed If no key supplied, the array of environmental variables that will be used by the process.
     *  Otherwise, the value of the environmental variable for the supplied key, or $default if no such variable.
     */
    public function getEnv($key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->_env;
        }

        if (!is_array($this->_env)) {
            return $default;
        }

        return isset($this->_env[$key])
            ? $this->_env[$key]
            : $default;
    }

    /**
     * Set a config option for the next run.
     *
     * @param string $key The config key to set the value for, or the whole config array.
     *  If array, the current config will be replaced by this.
     * @param null|string|int|bool $value The value to set.
     * @return \AdamBrett\ShellWrapper\Runners\Proc This intstance.
     */
    public function setConf($key, $value = null)
    {
        if (is_array($key)) {
            $this->_conf = $key;
            return $this;
        }

        $this->_conf[(string)$key] = (string)$value;
        return $this;
    }

    /**
     * Get a config option set for the next run.
     *
     * @see proc_open()
     * @param string|null $key The config key to retrieve the value for.
     * @param null|mixed $default What to return if key not found.
     * @return array|mixed|null An array of config options, if no key supplied.
     *  Otherwise, the option value for the supplied key, or the $default value if no such key.
     */
    public function getConf($key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->_conf;
        }

        return isset($this->_conf[$key])
            ? $this->_conf[$key]
            : $default;
    }

    /**
     * Set the input that will be fed to the process when run.
     *
     * @param string $input The input for the process.
     * @return \AdamBrett\ShellWrapper\Runners\Proc This instance.
     */
    public function setStandardInput($input)
    {
        $this->_stdin = $input;
        return $this;
    }

    /**
     * Gets the input for the process to be run.
     *
     * @return string The input that will be fed to the process when run.
     */
    public function getStandardInput()
    {
        return $this->_stdin;
    }

    /**
     * After a process was run, gets it's regular output, if any.
     *
     * @return string The standard output from an executed command.
     *  If no standard output, will be an empty string.
     */
    public function getStandardOutput()
    {
        return $this->_stdout;
    }

    /**
     * After a process was run, gets it's error output, if any.
     *
     * @return string The error output from an executed command.
     *  If no error output, will be an empty string.
     */
    public function getErrorOutput()
    {
        return $this->_stderr;
    }

    /**
     * Starts a process.
     *
     * @see proc_open()
     * @param string $cmd The command, for which a process should be opened.
     * @param array $descriptors An array of pipe descriptors.
     * @param array $pipes An array that will be filled with opened pipes, typically stdin, stdout and stderr.
     *  The pipes will correspond to their descriptor IDs.
     * @param string|null $cwd The working director, in which to execute the process.
     * @param array $env An array of environment variables for the process.
     * @param array $conf Other options.
     * @return resource|null The process handle resource if opened, or null if could not open.
     */
    protected function _open($cmd, $descriptors, &$pipes, $cwd, $env, $conf)
    {
        if (!is_resource($proc = proc_open($cmd, $descriptors, $pipes, $cwd, $env, $conf))) {
            return null;
        }

        return $proc;
    }

    /**
     * Feed the process with the stdin if any and close the pipe.
     *
     * Triggers a warning if there is something to write, but no open stdin pipe is available.
     *
     * @param array $buffers The array of data buffers, one of which is the data to write to the process via stdin.
     * @param array $pipes The array of open pipes, one of which is the stdin channel.
     * @return boolean True if there was something to write and it was written; false on error.
     */
    protected function _processInput(&$buffers, &$pipes)
    {
        // If nothing to write, we're done
        if (!isset($buffers[self::STDIN]) || !empty($buffers[self::STDIN])) {
            return true;
        }
        // If no stdin available, we have a problem
        if (!isset($pipes[self::STDIN]) || !isset($pipes[self::STDIN])) {
            trigger_error('Input is supplied, but standard input channel is not available', E_USER_WARNING);
            return false;
        }

        $result = fwrite($pipes[self::STDIN], $buffers[self::STDIN]);
        fclose($pipes[self::STDIN]);

        return $result;
    }

    /**
     * Initializes output buffers and pipe streams.
     *
     * @param array $buffers
     * @param array $pipes
     * @return array IDs of descriptors of open pipes.
     */
    protected function _prepareOutput(&$buffers, &$pipes)
    {
        // Setup non-blocking behaviour for stdout and stderr
        stream_set_blocking($pipes[self::STDOUT], 0);
        stream_set_blocking($pipes[self::STDERR], 0);

        // Initialize output strings
        $outputChannels = array(self::STDOUT, self::STDERR);
        foreach ($outputChannels as $_desc) {
            $buffers[$_desc] = empty($buffers[$_desc]) ? '' : $buffers[$_desc];
        }

        return $outputChannels;
    }

    /**
     * Reads a specified number of bytes of data from a stream.
     *
     * @see fread()
     * @param resource $stream The file system pointer to read from.
     * @return string The read data on success, or false on failure.
     */
    protected function _readFromStream($stream)
    {
        return fread($stream, self::READ_BUFFER_MAX);
    }

    /**
     * Ensure that the process is closed
     *
     * @see proc_terminate()
     * @see proc_close()
     * @param type $processHandle
     * @return int Exit code.
     */
    protected function _close($processHandle)
    {
        $status = proc_get_status($processHandle);
        if ($status['running']) {
            proc_terminate($processHandle);
        }

        return proc_close($processHandle);
    }

    /**
     * Retrieves the exit code of a closed process.
     *
     * @see proc_get_status()
     * @param resource $processHandle The resource of the process to get the exit code from.
     * @return int|null The exit code, if process is no longer running, or null.
     */
    protected function _attemptRetrieveExitCode($processHandle)
    {
        $status = proc_get_status($processHandle);
        if (!$status['running']) {
            return $status['exitcode'];
        }

        return null;
    }

    /**
     * Sleeps, and calculates the new sleep length.
     *
     * @see usleep()
     * @param int $delay How long to sleep for, in milliseconds.
     * @return int The new sleep delay.
     */
    protected function _handleSleep($delay)
    {
        if ($delay) {
            usleep($delay * 1000);
            return ceil(min(self::SLEEP_MAX, $delay * self::SLEEP_FACTOR));
        }

        return self::SLEEP_START;
    }

    /**
     * Reads the data from open pipes.
     *
     * Also, tries to retrieve the exit code, if possible.
     * Reads all data, and sleeps in between reads.
     *
     * @param array $openIndexes An array of IDs of descriptors that correspond to open pipes that should be read from.
     * @param array $buffers The buffers that will be filled with data. Each one corresponds to the pipe that the data was read from, by ID.
     * @param array $pipes All the pipes that were opened with proc_open().
     * @param resource $ph The resource representing the open process, the pipes of which are to be read from.
     * @param callable $callback This will be called every time a read occurs, or when nothing else to read.
     *  When called on read, will receive the ID of the pipe from which data was read, and the data.
     *  When nothing else to read, receives `null` instead of the data.
     * @return int|null The exit code, if determined.
     */
    protected function _processOpenPipes($openIndexes, &$buffers, &$pipes, $ph, $callback)
    {
        $delay = 0;
        $exitCode = null;

        // If there are open pipes, start read loop
        while (!empty($openIndexes)) {
            // Try to find the exit code of the command before buggy proc_close()
            if (is_null($exitCode)) {
                $exitCode = $this->_attemptRetrieveExitCode($ph);
            }

            // Go through all open pipes and check for data
            foreach ($openIndexes as $i => $_pipeIdx) {
                // Try to get some data
                $output = $this->_readFromStream($pipes[$_pipeIdx]);

                if (strlen($output)) {
                    if ($callback) {
                        $output = call_user_func_array($callback, array($_pipeIdx, $output));
                        if ($output === false) {
                            break 2;
                        }
                    } else {
                        $buffers[$_pipeIdx] .= $output;
                    }
                    // Since we've got some data we don't need to sleep :)
                    $delay = 0;
                    // Check if we have consumed all the data in the current pipe
                } else if (feof($pipes[$_pipeIdx])) {
                    if ($callback) {
                        if (call_user_func_array($callback, array($_pipeIdx, null)) === false) {
                            break 2;
                        }
                    }
                    unset($openIndexes[$i]);
                    continue 2;
                }
            }
            // Check if we have to sleep to reduce CPU load while waiting for data
            $delay = $this->_handleSleep($delay);
        }

        return $exitCode;
    }

    /**
     * Closes open pipes.
     *
     * @see fclose()
     * @param array $pipes The array of open pipes, by descriptor ID.
     * @param callable $callback This will be called when/if an open pipe is closed, receiving the pipe ID and `null` instead of data.
     * @return \AdamBrett\ShellWrapper\Runners\Proc This instance.
     */
    protected function _closeOpenPipes(&$pipes, $callback)
    {
        foreach ($pipes as $_pipeIdx => $pipe) {
            if (is_resource($pipe)) {
                if ($callback) {
                    call_user_func_array($callback, array($_pipeIdx, null));
                }
                fclose($pipe);
            }
        }

        return $this;
    }

    /**
     * Executes a command returning the exitcode and capturing the stdout and stderr
     *
     * @param string $cmd
     * @param array &$buffers
     *  0 - StdIn contents to be passed to the command (optional)
     *  1 - StdOut contents returned by the command execution
     *  2 - StdOut contents returned by the command execution
     * @param callback $callback  A callback function for stdout/stderr data
     * @param string $cwd Set working directory
     * @param array $env Environment variables for the process
     * @param array $conf Additional options for proc_open()
     * @return int The exit code.
     */
    public function exec($cmd, &$buffers, $callback = null, $cwd = null, $env = null, $conf = null)
    {
        $this->reset();

        if (!is_array($buffers)) {
            $buffers = array();
        }
        // Define the pipes to configure for the process
        $pipes = array();
        // Start the process
        if (!($ph = $this->_open($cmd, $this->getDescriptors(), $pipes, $cwd, $env, $conf))) {
            return null;
        }

        // Give the input to the process
        $this->_processInput($buffers, $pipes);
        // Initialize output streams and buffers
        $openPipeIndexes = $this->_prepareOutput($buffers, $pipes);
        // Read output, and try to determine exit code
        $exitCode = $this->_processOpenPipes($openPipeIndexes, $buffers, $pipes, $ph, $callback);
        // Make sure all pipes are closed
        $this->_closeOpenPipes($pipes, $callback);

        // Close process
        $closeCode = $this->_close($ph);
        // If not already determined, use buggy value
        $exitCode = is_null($exitCode) ? $closeCode : $exitCode;

        return $exitCode;
    }
}
