<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\Usuario;

class UsuarioController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Usuario';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Usuario());

        $grid->column('id', __('Id'));
        $grid->column('nombre', __('Nombre'));
        $grid->column('apellido', __('Apellido'));
        $grid->column('correo', __('Correo'));
        $grid->column('telefono', __('Telefono'));
        $grid->column('rut', __('Rut'));
        $grid->column('imc', __('Imc'));
        $grid->column('fechaN', __('FechaN'));
        $grid->column('password', __('Password'));
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
        $show = new Show(Usuario::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('nombre', __('Nombre'));
        $show->field('apellido', __('Apellido'));
        $show->field('correo', __('Correo'));
        $show->field('telefono', __('Telefono'));
        $show->field('rut', __('Rut'));
        $show->field('imc', __('Imc'));
        $show->field('fechaN', __('FechaN'));
        $show->field('password', __('Password'));
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
        $form = new Form(new Usuario());

        $form->text('nombre', __('Nombre'));
        $form->text('apellido', __('Apellido'));
        $form->text('correo', __('Correo'));
        $form->text('telefono', __('Telefono'));
        $form->text('rut', __('Rut'));
        $form->decimal('imc', __('Imc'));
        $form->date('fechaN', __('FechaN'))->default(date('Y-m-d'));
        $form->password('password', __('Password'));

        return $form;
    }
}
