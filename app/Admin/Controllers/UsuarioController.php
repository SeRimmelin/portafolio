<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use App\Models\Usuario;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class UsuarioController extends AdminController
{
    protected $title = 'Usuario';

    protected function grid()
    {
        $grid = new Grid(new Usuario());

        $grid->column('id', __('Id'));
        $grid->column('nombre', __('Nombre'));
        $grid->column('apellido', __('Apellido'));
        $grid->column('correo', __('Correo'));
        $grid->column('telefono', __('Telefono'));
        $grid->column('rut', __('Rut'));
        $grid->column('fechaN', __('FechaN'));
        $grid->column('password', __('Password'));
        $grid->column('peso', __('Peso'));
        $grid->column('altura', __('Altura'));
        $grid->column('imc', __('Imc'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(Usuario::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('nombre', __('Nombre'));
        $show->field('apellido', __('Apellido'));
        $show->field('correo', __('Correo'));
        $show->field('telefono', __('Telefono'));
        $show->field('rut', __('Rut'));
        $show->field('fechaN', __('FechaN'));
        $show->field('password', __('Password'));
        $show->field('peso', __('Peso'));
        $show->field('altura', __('Altura'));
        $show->field('imc', __('Imc'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    protected function form()
    {
        $form = new Form(new Usuario());

        $form->text('nombre', __('Nombre'));
        $form->text('apellido', __('Apellido'));
        $form->text('correo', __('Correo'));
        $form->text('telefono', __('Telefono'));
        $form->text('rut', __('Rut'));
        $form->date('fechaN', __('FechaN'))->default(date('Y-m-d'));
        $form->password('password', __('Password'));
        $form->decimal('peso', __('Peso'));
        $form->decimal('altura', __('Altura'));
        $form->decimal('imc', __('Imc'));

        $form->saved(function (Form $form) {
            Log::info('Usuario guardado, enviando a API...', ['usuario' => $form->model()]);
            $this->sendToApi($form->model());
        });

        return $form;
    }

    protected function sendToApi(Usuario $usuario)
    {
        $client = new Client();
        $url = 'https://a959-190-114-40-115.ngrok-free.app/api/users';

        try {
            Log::info('Enviando solicitud POST a API', ['url' => $url, 'usuario' => $usuario]);
            $response = $client->post($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'nombre' => $usuario->nombre,
                    'apellido' => $usuario->apellido,
                    'email' => $usuario->correo,
                    'telefono' => $usuario->telefono,
                    'rut' => $usuario->rut,
                    'fechaN' => $usuario->fechaN, // No es necesario formatear ya que es una cadena
                    'password' => $usuario->password,
                    'peso' => $usuario->peso,
                    'altura' => $usuario->altura,
                    'imc' => $usuario->imc,
                ],
                'verify' => false, // Desactiva la verificación SSL
            ]);

            Log::info('Respuesta de la API', ['status' => $response->getStatusCode(), 'body' => $response->getBody()]);

            if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
                admin_success('Datos enviados a la API con éxito.');
            } else {
                admin_error('Error al enviar datos a la API: ' . $response->getBody());
            }
        } catch (\Exception $e) {
            Log::error('Excepción al enviar datos a la API', ['error' => $e->getMessage()]);
            admin_error('Excepción al enviar datos a la API: ' . $e->getMessage());
        }
    }

}
