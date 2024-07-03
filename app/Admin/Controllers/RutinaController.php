<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\ApiController;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\Rutina;

class RutinaController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Rutina';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Rutina());

        $grid->column('id', __('Id'));
        $grid->column('image') -> image();
        $grid->column('nombre', __('Nombre'));
        $grid->column('series', __('Series'));
        $grid->column('repeticiones', __('Repeticiones'));
        $grid->column('descripción', __('Descripción'));
        $grid->column('duración', __('Duración'));
        $grid->column('categoria', __('Categoria'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Rutina::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('image', __('Image'));
        $show->field('nombre', __('Nombre'));
        $show->field('series', __('Series'));
        $show->field('repeticiones', __('Repeticiones'));
        $show->field('descripción', __('Descripción'));
        $show->field('duración', __('Duración'));
        $show->field('categoria', __('Categoria'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Rutina());

        $form->image('image', __('Image'));
        $form->text('nombre', __('Nombre'));
        $form->number('series', __('Series'));
        $form->number('repeticiones', __('Repeticiones'));
        $form->text('descripción', __('Descripción'));
        $form->time('duración', __('Duración'))->default(date('H:i:s'));
        $form->text('categoria', __('Categoría'));

        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
            $tools->disableList();

            // Botón personalizado para enviar a API
            $tools->append('<button type="submit" class="btn btn-primary mr-2" id="enviarAPI">Enviar a API</button>');
        });

        // Acción de envío a API al guardar
        $form->saving(function (Form $form) {
            // Lógica para enviar datos a la API
            $apiController = new ApiController();
            $response = $apiController->sendRoutineData($form->model());

            // Manejo de la respuesta de la API
            if ($response->getStatusCode() == 200) {
                admin_toastr('Datos de rutina enviados a la API correctamente', 'success');
            } else {
                admin_toastr('Error al enviar datos de rutina a la API', 'error');
            }
        });

        return $form;
    }
}
