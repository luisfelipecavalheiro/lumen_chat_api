<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;


class ClientController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
    */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    
    /**
     *  Retorna todos os clientes cadastrados
    */
    public function index()
    {     
        $client = $this->client->all();

        /** Mensagem de Retorno API*/
        return ['msg' => 'Client found', 'error' => null, 'data' =>$client];
    }

    /**
     * Valida cadastro do cliente através do email
     */
    public function validated(Request $request)
    {       
            $client = new Client;            
            $client_email = $request->email;
            
            $clients = $this->client->where('email', $client_email)->exists();

        if ($clients === true) {

            $cliente_nome = null;

            $cliente = $this->client->where('email', $client_email)->get();

            foreach ($cliente as $cli) {
                $cliente_id = $cli->id;
                $cliente_nome = $cli->name;
                $cliente_img = $cli->image;
            }
            /**Atribue a variavel exists o valor true - utilizado no login do app  */
            $exists = true;

            $user_data = $this->client->find($cliente_id);

            $msg = "error: 0, message : Usuário cadastrado!";

             /** Mensagem de Retorno API em caso de sucesso ao consultar email*/

            return ['msg' => $msg, 'user' => $user_data, 'exists' => $exists];
                   
        }
        
        if ($clients === false) {
            /**Atribue a variavel exists o valor true - utilizado no login do app  */
            $exists= false;

            /** Mensagem de Retorno API caso cliente não esteja cadastrado com email*/
            $msg = "ErrorCode: 401 - Usuário não Cadastrado :: Request failed with status code 401";
            
            return ['UserData' => ['id' => null, 'name' => null, 'email' => null, 'image' => null, 'created_at' => null, 'updated_at' => null], 'exists' => $exists];
            
        } 
    }
    
    /**
     * Realiza cadastro de cliente
     */
    public function store(Request $request)
    {

        try
        {
            $client = new Client;
            $client->name= $request->name;
            $client->email = $request->email;
            $client->image= $request->image;
       
            $client->save();  

            /** Mensagem de Retorno parda API em caso de sucesso*/
            return ['msg' => ['error' => '0', 'message' => 'usuário cadastrado com sucesso']];
 

        } catch(\Exception $error){

            /** Mensagem de Retorno API em caso de erro*/
            return ['msg' => ['ErrorCode' => 'undefined - Usuário já cadastrado', 'PluginErrorError' => 'Request failed with status code 401']];

        }
    }    
}