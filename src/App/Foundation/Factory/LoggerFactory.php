<?php declare(strict_types=1);

namespace App\Foundation\Factory;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class LoggerFactory
{
    /**
     * @access  private
     * @var     string  Log path
     */
    private string $path;

    /**
     * @access  private
     * @var     int     Log level
     */
    private int $level;

    /**
     * @access  private
     * @var     array   Log handlers
     */
    private array $handler = [];

    /**
     * LoggerFactory constructor.
     *
     * @access  public
     * @param   array $settings
     */
    public function __construct(array $settings)
    {
        $this->path     = (string)$settings['path'];
        $this->level    = (int)$settings['level'];
    }

    /**
     * Create logger instance.
     *
     * @access  public
     * @param   string $name
     * @return  \Psr\Log\LoggerInterface
     */
    public function createInstance(string $name) : LoggerInterface
    {
        $logger = new Logger($name);

        // Add handlers to logger instance
        foreach ($this->handler as $handler) {
            $logger->pushHandler($handler);
        }

        // reset handler stack
        $this->handler = [];

        return $logger;
    }

    /**
     * Add rotating file logger handler.
     *
     * @access  public
     * @param   string  $filename   Log file.
     * @param   int     $level      Log level.
     * @return  self    \App\LoggerFactory
     */
    public function addFileHandler(string $filename, int $level = null) : self
    {
        // Add path to filename
        $filename = sprintf('%s/%s', $this->path, $filename);

        $rotatingFileHandler = new RotatingFileHandler(
            $filename,
            0,
            $level ?? $this->level,
            true,
            0777
        );

        $rotatingFileHandler->setFormatter(
            new LineFormatter(null, null, false, true)
        );

        // Push handler to stack
        $this->handler[] = $rotatingFileHandler;

        return $this;
    }

    /**
     * Add a console logger.
     *
     * @access public
     * @param  int      $level  Log level.
     * @return self \App\LoggerFactory
     */
    public function addConsoleLogger(int $level = null) : self
    {
        $streamHandler = new StreamHandler('php://stdout', $level ?? $this->level);
        $streamHandler->setFormatter(
            new LineFormatter(null, null, false, true)
        );

        // Push handler to the stack
        $this->handler[] = $streamHandler;

        return $this;
    }
}
