<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Response as LaravelResponse;

class APIBaseController extends BaseController
{
    protected $success = 1;
    protected $code = 200;
    protected $method;
    protected $endpoint;
    protected $offset = 0;
    protected $limit = 30;
    protected $total;
    protected $data = [];
    protected $errors = [];
    protected $duration = 0;
    protected $starttime = 0;

    public function  make()
    {
        return [
            'success'   => $this->success,
            'code'      => $this->getStatusCode(),
            'meta'      => $this->getMeta(),
            'data'      => $this->data,
            'error'     => $this->getErrors(),
            'duration'  => $this->calcDuration()
        ];
    }

    public function response($code = null)
    {
        if(count($this->errors)>0) : $this->success = 0; endif;
        $code = is_null($code) ? $this->getStatusCode() : $this->code = (int)$code;
        
        $r = $this->make();

        $response = LaravelResponse::json($r,$code);
        
        $response->header('Content-Type','application/json');
        $response->header('Access-Control-Allow-Origin','*');
        return $response;
    }

    public function success($success)
    {
        $this->success = $success;
        return $this;
    }

    public function code($code)
    {
        $this->code = (int)$code;
        return $this;
    }

    public function method($method)
    {
        $this->method = $method;
        return $this;
    }

    public function endpoint($endpoint)
    {
        $this->endpoint = $endpoint;
        return $this;
    }
    public function total($total)
    {
        $this->total = $total;
        return $this;
    }

    public function offset($offset)
    {
        $this->offset = $offset;
        return $this;
    }
    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }
    public function data($data)
    {
        $this->data = array_merge($this->data,$data);
        return $this;
    }

    public function errors(array $errors)
    {
        $this->errors = array_merge($this->errors,$errors);
        return $this;
    }
    public function getStatusCode()
    {
        if ($this->code > 100000) {
            return intval($this->code / 1000);
        }else{
            return $this->code;
        }
    }

    public function getMeta()
    {
        $meta = [
            'method'    => $this->method,
            'endpoint'  => $this->endpoint
        ];
        if ($this->limit !== null) {
            $meta['limit'] = (int)$this->limit;
        }
        if ($this->offset !== null) {
            $meta['offset'] = (int)$this->offset;
        }
        if ($this->total !== null) {
            $meta['total'] = (int)$this->total;
        }

        return $meta;
    }

    public function getErrors()
    {
        $errors = $this->errors;
        if(empty($errors)){
            $errors = (object)$errors;
        }
        return $errors;
    }

    public function calcDuration()
    {
        $now = microtime(true);
        return $this->duration = (float)sprintf("%.3f", ($now - $this->startTime));
    }

    public function setError($error_code,$id = 0)
    {
        
        switch($error_code){
            case '400':
            $error = array(
                'message'   => 'The request parameters are incorrect, please make sure to follow the ducumentation.',
                'code'      => 4000002
            );
            $this->errors($error);
            break;

            case '404':
            $error = array(
                'message'   => 'The resource that match ID : '.$id.' does not found ',
                'code'      => 404001
            );
            $this->errors($error);
            break;

            case '500':
            $error = array(
                'message'   => 'A fatal error occured please try again later',
                'code'      => 50010
            );
            $this->errors($error);
            break;

        }
    }
}