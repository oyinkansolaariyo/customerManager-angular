<?php
/**
 * Created by PhpStorm.
 * User: itunu.babalola
 * Date: 1/30/17
 * Time: 12:58 PM
 */

namespace Utils;


class Response
{
    protected $type;
    protected $response;
    protected $rawBody;
    protected $header;
    protected $code;
    protected $responsePhrase;

    public function __construct($type=null, $response=null)
    {
        if(!is_null($type)) { $this->type = $type;}
        if(!is_null($response)) { $this->response = $response;}
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getResponsePhrase()
    {
        return $this->responsePhrase;
    }

    /**
     * @param mixed $responsePhrase
     */
    public function setResponsePhrase($responsePhrase)
    {
        $this->responsePhrase = $responsePhrase;
    }

    /**
     * @return mixed
     */
    public function getRawBody()
    {
        return $this->rawBody;
    }

    /**
     * @param mixed $rawBody
     */
    public function setRawBody($rawBody)
    {
        $this->rawBody = $rawBody;
    }

    /**
     * @return mixed
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param mixed $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }


    /**
     * @return null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param null $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return null
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param null $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    public function isSuccessful() {
        if($this->response == null) {return false;}
        if(!is_array($this->response)) {return false;}
        if(sizeof($this->response) == 0) {return false;}
        return $this->response['status'] == ResponseStatus::$SUCCESS;
    }

    /**
     * @param $message String
     * @return array
     */
    public static function sendErrorJSON($message) {
        return ['status' => 'error', 'message' => $message];
    }

    /**
     * @param $data object | array
     * @return array
     */
    public static function sendSuccessJSON($data) {
        return ['status' => 'success', 'data' => $data];
    }


}