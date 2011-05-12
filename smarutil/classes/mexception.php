<?php defined('SYSTEMPATH') or die('No direct script access.');

class MException extends Exception {


	/**
	 * @var  array  PHP error code => human readable name
	 */
	public static $php_errors = array(
		E_ERROR              => 'Fatal Error',
		E_USER_ERROR         => 'User Error',
		E_PARSE              => 'Parse Error',
		E_WARNING            => 'Warning',
		E_USER_WARNING       => 'User Warning',
		E_STRICT             => 'Strict',
		E_NOTICE             => 'Notice',
		E_RECOVERABLE_ERROR  => 'Recoverable Error',
	);

	/**
	 * @var  string  error rendering view
	 */
	public static $error_view = 'error';

	/**
	 * Creates a new translated exception.
	 *
	 *     throw new Kohana_Exception('Something went terrible wrong, :user',
	 *         array(':user' => $user));
	 *
	 * @param   string   error message
	 * @param   array    translation variables
	 * @param   integer  the exception code
	 * @return  void
	 */
	public function __construct($message, array $variables = NULL, $code = 0)
	{
		if (defined('E_DEPRECATED'))
		{
			// E_DEPRECATED only exists in PHP >= 5.3.0
			MException::$php_errors[E_DEPRECATED] = 'Deprecated';
		}

		// Set the message
		$message = strtr($message, $variables);

		// Pass the message to the parent
		parent::__construct($message, $code);
	}

	/**
	 * Magic object-to-string method.
	 *
	 *     echo $exception;
	 *
	 * @uses    MException::text
	 * @return  string
	 */
	public function __toString()
	{
		return MException::text($this);
	}

	/**
	 * Inline exception handler, displays the error message, source of the
	 * exception, and the stack trace of the error.
	 *
	 * @uses    Kohana_Exception::text
	 * @param   object   exception object
	 * @return  boolean
	 */
	public static function handler(Exception $e)
	{
		//print $e->getFile().' '.get_class($e)." thrown exception. Message: ".$e->getMessage()." on line ".$e->getLine();
		
		// Get the exception information
		$type    = get_class($e);
		$code    = $e->getCode();
		$message = $e->getMessage();
		$file    = $e->getFile();
		$line    = $e->getLine();

		// Get the exception backtrace
		$trace = $e->getTrace();
			
		if ($view_file = Core::find_file('views', MException::$error_view))
		{
			include $view_file;
		}
			
		exit();
		
		try
		{
			// Get the exception information
			$type    = get_class($e);
			$code    = $e->getCode();
			$message = $e->getMessage();
			$file    = $e->getFile();
			$line    = $e->getLine();

			// Get the exception backtrace
			$trace = $e->getTrace();

			if ($e instanceof ErrorException)
			{
				if (isset(MException::$php_errors[$code]))
				{
					// Use the human-readable error name
					$code = MException::$php_errors[$code];
				}

				if (version_compare(PHP_VERSION, '5.3', '<'))
				{
					// Workaround for a bug in ErrorException::getTrace() that exists in
					// all PHP 5.2 versions. @see http://bugs.php.net/bug.php?id=45895
					for ($i = count($trace) - 1; $i > 0; --$i)
					{
						if (isset($trace[$i - 1]['args']))
						{
							// Re-position the args
							$trace[$i]['args'] = $trace[$i - 1]['args'];

							// Remove the args
							unset($trace[$i - 1]['args']);
						}
					}
				}
			}
			
			// Create a text version of the exception
			$error = MException::text($e);
			

			if ( ! headers_sent())
			{
				// Make sure the proper http header is sent
				$http_header_status = 500;

				header('Content-Type: text/html; charset='.Core::$charset, TRUE, $http_header_status);
			}

			// Start an output buffer
			ob_start();

			// Include the exception HTML
			if ($view_file = Core::find_file('views', MException::$error_view))
			{
				include $view_file;
			}
			else
			{
				echo strtr('Error view file does not exist: views/:file', array(
					':file' => MException::$error_view,
				));
			}

			// Display the contents of the output buffer
			echo ob_get_clean();
			
			return TRUE;
		}
		catch (Exception $e)
		{
			// Clean the output buffer if one exists
			ob_get_level() and ob_clean();

			// Display the exception text
			echo MException::text($e), "\n";

			// Exit with an error status
			exit(1);
		}
	}

	/**
	 * Get a single line of text representing the exception:
	 *
	 * Error [ Code ]: Message ~ File [ Line ]
	 *
	 * @param   object  Exception
	 * @return  string
	 */
	public static function text(Exception $e)
	{
		return sprintf('%s [ %s ]: %s ~ %s [ %d ]',
			get_class($e), $e->getCode(), strip_tags($e->getMessage()), Core::path($e->getFile()), $e->getLine());
	}

} // End MException
	