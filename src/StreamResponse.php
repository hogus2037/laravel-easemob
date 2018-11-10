<?php

namespace Hogus\LaravelEasemob;

use GuzzleHttp\Psr7\Response;
use Hogus\LaravelEasemob\Exceptions\InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;

class StreamResponse extends Response
{
    /**
     * @param string $directory
     * @param string $filename
     * @return string
     * @throws InvalidArgumentException
     */
    public function save(string $directory, string $filename = '')
    {
        $this->getBody()->rewind();

        $directory = rtrim($directory, '/');

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true); // @codeCoverageIgnore
        }

        if (!is_writable($directory)) {
            throw new InvalidArgumentException(sprintf("'%s' is not writable.", $directory));
        }

        $contents = $this->getBody()->getContents();

        if (empty($contents) || '{' === $contents[0]) {
            throw new \RuntimeException('Invalid media response content.');
        }

        if (empty($filename)) {
            if (preg_match('/filename="(?<filename>.*?)"/', $this->getHeaderLine('Content-Disposition'), $match)) {
                $filename = $match['filename'];
            } else {
                $filename = md5($contents);
            }
        }

        file_put_contents($directory.'/'.$filename, $contents);

        return $filename;
    }

    /**
     * @param string $directory
     * @param string $filename
     * @return string
     * @throws InvalidArgumentException
     */
    public function saveAs(string $directory, string $filename)
    {
        return $this->save($directory, $filename);
    }

    /**
     * @param ResponseInterface $response
     * @return StreamResponse
     */
    public static function buildFromPsrResponse(ResponseInterface $response)
    {
        return new static(
            $response->getStatusCode(),
            $response->getHeaders(),
            $response->getBody(),
            $response->getProtocolVersion(),
            $response->getReasonPhrase()
        );
    }

}
