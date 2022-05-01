<?php


namespace Serato\Tests\Unit\Web;


use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\StreamFactory;
use PHPUnit\Framework\TestCase;
use Serato\Web\Controller;
use stdClass;

class ControllerTest extends TestCase
{
    private static Controller $controller;
    private static StreamFactory $streamFactory;

    public static function setUpBeforeClass(): void
    {
        self::$controller = new Controller();
        self::$controller->init();
        self::$streamFactory = new StreamFactory();
    }
    //JSON data

    /**
     * @test
     * data ['userId' => 2000, 'fieldId' => 1000] sent as url query params and sent back as a json from the server
     */
    public function jsonMessageGet()
    {
        $stream = self::$streamFactory->createStream();

        $request = new ServerRequest([], [], '', 'GET', $stream,
            [
                'Content-Type' => 'application/json',
            ], [], ['userId' => 2000, 'fieldId' => 1000]
        );

        $response = self::$controller->execute($request, new Response());

        $this->assertEquals('200', $response->getStatusCode());
        $this->assertEquals('{"userId":2000,"fieldId":1000}', (string)$response->getBody());
        $this->assertEquals('application/json; charset=utf-8', $response->getHeader('Content-Type')[0]);
    }

    /**
     * @test
     * json object sent in the GET body and server ignored the body and sent empty [] array response.
     */
    public function jsonMessageGetBodyIgnored()
    {
        $message = new stdClass();
        $message->type = "json";
        $message->message = "This is a JSON message";
        $stream = self::$streamFactory->createStream(json_encode($message));

        $request = new ServerRequest([], [], '', 'GET', $stream,
            [
                'Content-Type' => 'application/json',
            ]
        );

        $response = self::$controller->execute($request, new Response());

        $this->assertEquals('200', $response->getStatusCode());
        $this->assertEquals('[]', (string)$response->getBody());
        $this->assertEquals('application/json; charset=utf-8', $response->getHeader('Content-Type')[0]);
    }


    /**
     * @test
     * trying to send invalid json in a GET request body. it is ignored by server.
     */
    public function invalidJsonMessageGet()
    {
        $stream = self::$streamFactory->createStream(json_encode('{"json","This is a JSON message"}'));
        $request = new ServerRequest([], [], '', 'GET', $stream,
            [
                'Content-Type' => 'application/json',
            ]
        );

        $response = self::$controller->execute($request, new Response());

        $this->assertEquals('200', $response->getStatusCode());
        $this->assertEquals('[]', (string)$response->getBody());
        $this->assertEquals('application/json; charset=utf-8', $response->getHeader('Content-Type')[0]);
    }


    /**
     * @test
     * valid json message sent to server as a POST request
     */
    public function jsonMessagePost()
    {
        $message = new stdClass();
        $message->type = "json";
        $message->message = "This is a JSON message";
        $stream = self::$streamFactory->createStream(json_encode($message));

        $request = new ServerRequest([], [], '', 'POST', $stream,
            [
                'Content-Type' => 'application/json',
            ]
        );

        $response = self::$controller->execute($request, new Response());

        $this->assertEquals('200', $response->getStatusCode());
        $this->assertEquals('"{\"type\":\"json\",\"message\":\"This is a JSON message\"}"', (string)$response->getBody());
        $this->assertEquals('application/json; charset=utf-8', $response->getHeader('Content-Type')[0]);
    }

    /**
     * @test
     * trying to POST invalid json message
     */
    public function invalidJsonMessagePost()
    {
        $stream = self::$streamFactory->createStream(json_encode('{"json","This is a JSON message"}'));
        $request = new ServerRequest([], [], '', 'POST', $stream,
            [
                'Content-Type' => 'application/json',
            ]
        );

        $response = self::$controller->execute($request, new Response());

        $this->assertEquals('400', $response->getStatusCode());
        $this->assertEquals('Bad JSON Content', $response->getReasonPhrase());
    }

    /**
     * @test
     * valid json message sent to server as a PUT request
     */
    public function jsonMessagePut()
    {
        $message = new stdClass();
        $message->type = "json";
        $message->message = "This is a JSON message";
        $stream = self::$streamFactory->createStream(json_encode([$message]));

        $request = new ServerRequest([], [], '', 'PUT', $stream,
            [
                'Content-Type' => 'application/json',
            ]
        );

        $response = self::$controller->execute($request, new Response());

        $this->assertEquals('200', $response->getStatusCode());
        $this->assertEquals('"[{\"type\":\"json\",\"message\":\"This is a JSON message\"}]"', (string)$response->getBody());
        $this->assertEquals('application/json; charset=utf-8', $response->getHeader('Content-Type')[0]);
    }

    /**
     * @test
     * trying to PUT invalid json message
     */
    public function invalidJsonMessagePut()
    {
        $stream = self::$streamFactory->createStream(json_encode('{"json","This is a JSON message"}'));
        $request = new ServerRequest([], [], '', 'PUT', $stream,
            [
                'Content-Type' => 'application/json',
            ]
        );

        $response = self::$controller->execute($request, new Response());

        $this->assertEquals('400', $response->getStatusCode());
        $this->assertEquals('Bad JSON Content', $response->getReasonPhrase());
    }

    //form data


    /**
     * @test
     * form data is sent with get request body and ignored by the server
     */
    public function jsonMessageFormGetBodyIgnored()
    {
        $message = new stdClass();
        $message->type = "json";
        $message->message = "This is a JSON message";
        $stream = self::$streamFactory->createStream(json_encode($message));

        $request = new ServerRequest([], [], '', 'GET', $stream,
            [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ]
        );

        $response = self::$controller->execute($request, new Response());

        $this->assertEquals('200', $response->getStatusCode());
        $this->assertEquals('<h1>Html Response</h1></br><h2> Html response for GET request[]</h2>', (string)$response->getBody());
        $this->assertEquals('text/html; charset=utf-8', $response->getHeader('Content-Type')[0]);
    }


    /**
     * @test
     * form data is sent with the header application/x-www-form-urlencoded and html is received
     */
    public function formMessagePostEncoded()
    {
        $message = new stdClass();
        $message->type = "json";
        $message->message = "This is a JSON message";

        $request = new ServerRequest([], [], '', 'POST', self::$streamFactory->createStream(),
            [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ], [], [], $message
        );

        $response = self::$controller->execute($request, new Response());

        $this->assertEquals('200', $response->getStatusCode());
        $this->assertEquals('<h1>Html Response</h1></br><h2> Html response</h2>', (string)$response->getBody());
        $this->assertEquals('text/html; charset=utf-8', $response->getHeader('Content-Type')[0]);
    }

    /**
     * @test
     * form data is sent with the header multipart/form-data and html is received
     */
    public function formMessagePostMultipart()
    {
        $message = new stdClass();
        $message->type = "json";
        $message->message = "This is a JSON message";

        $request = new ServerRequest([], [], '', 'POST', self::$streamFactory->createStream(),
            [
                'Content-Type' => 'multipart/form-data',
            ], [], [], $message
        );

        $response = self::$controller->execute($request, new Response());

        $this->assertEquals('200', $response->getStatusCode());
        $this->assertEquals('<h1>Html Response</h1></br><h2> Html response</h2>', (string)$response->getBody());
        $this->assertEquals('text/html; charset=utf-8', $response->getHeader('Content-Type')[0]);
    }
}