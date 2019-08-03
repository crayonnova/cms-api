<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\APIBaseController;
use App\Repositories\User\UserInterface as UserInterface;
use App\User;


class UserController extends APIBaseController
{
   private $user;
    public function __construct(UserInterface $user,Request $request)
    {
        $this->user = $user;
        $this->method = $request->getMethod();
        $this->endpoint = $request->path();
        $this->startTime = microtime(true);
    }
    public function index(Request $request)
    {
        $this->offset   = isset($request->offset)? $request->offset :0;
        $this->limit    = isset($request->limit)? $request->limit : 30;

        $users = $this->user->getAll($this->offset,$this->limit);

        $total = User::count();

        $this->data($users);
        $this->total($total);
        return $this->response('200');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
           
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        $import = array(
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => $request->get('password')
        );
        // $this->user->name = $request->get('name');
        // $this->user->email = $request->get('email');
        // $this->user->password = $request->get('password');
        // $this->user->remember_token = $request->get('remember_token');
        
        $id = $this->user->save($import);
        // dd($id);
        if($id){
            $this->data(array("data"=> $id));
            return $this->response('201');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $user = $this->user->find($id);
       if(empty($user)){
           $this->setError('404',$id);
           return $this->response('404');
       }else{
           $this->data(array($user));
           return $this->response('200');
       }
        // return view('users.show',['user']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
       

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);
         // dd($request->get('name'));
        // $this->user->update()
         $data = array(
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
         );
         $data['id'] = $id;
         dd($data);
         $result = $this->user->update($data);
         // dd($result);
         if ($result) {
            $this->data(array('Updated record!' => ''));
            return $this->response('200');
             
         }else{
            $this->setError('404',$id);
             return $this->response('404');
         }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);
        $user = User::find($id);
        // dd($user);
        if (empty($user)) {

            $this->setError('404',$id);
            return $this->response('404');
        }else{
            $user = User::find($id)->delete();
            // dd($user);
            $this->data(array('deleted' => 1));
            return $this->response('200');
        }
        // $this->user->delete($id);
        // return "Deleted";
        // return redirect()->route('users');
    }
}
