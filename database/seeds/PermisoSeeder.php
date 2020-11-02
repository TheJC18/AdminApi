<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Permisos para controladores
        Permission::create(['name' => 'listado_ajuste']);
        Permission::create(['name' => 'ver_ajuste']);
        Permission::create(['name' => 'actualizar_ajuste']);
        Permission::create(['name' => 'crear_ajuste']);
        Permission::create(['name' => 'eliminar_ajuste']);

        Permission::create(['name' => 'listado_cliente']);
        Permission::create(['name' => 'listado_e_cliente']);
        Permission::create(['name' => 'ver_cliente']);
        Permission::create(['name' => 'actualizar_cliente']);
        Permission::create(['name' => 'crear_cliente']);
        Permission::create(['name' => 'eliminar_cliente']);

        Permission::create(['name' => 'listado_compra']);
        Permission::create(['name' => 'listado_e_compra']);
        Permission::create(['name' => 'ver_compra']);
        Permission::create(['name' => 'actualizar_compra']);
        Permission::create(['name' => 'crear_compra']);
        Permission::create(['name' => 'eliminar_compra']);

        Permission::create(['name' => 'listado_configuracion']);
        Permission::create(['name' => 'ver_configuracion']);
        Permission::create(['name' => 'actualizar_configuracion']);
        Permission::create(['name' => 'crear_configuracion']);
        Permission::create(['name' => 'eliminar_configuracion']);

        Permission::create(['name' => 'listado_cotizacion']);
        Permission::create(['name' => 'listado_e_cotizacion']);
        Permission::create(['name' => 'ver_cotizacion']);
        Permission::create(['name' => 'actualizar_cotizacion']);
        Permission::create(['name' => 'crear_cotizacion']);
        Permission::create(['name' => 'eliminar_cotizacion']);

        Permission::create(['name' => 'listado_dolar']);
        Permission::create(['name' => 'listado_e_dolar']);
        Permission::create(['name' => 'ver_dolar']);
        Permission::create(['name' => 'actualizar_dolar']);
        Permission::create(['name' => 'crear_dolar']);
        Permission::create(['name' => 'eliminar_dolar']);

        Permission::create(['name' => 'listado_equilibrio']);
        Permission::create(['name' => 'ver_equilibrio']);
        Permission::create(['name' => 'actualizar_equilibrio']);
        Permission::create(['name' => 'crear_equilibrio']);
        Permission::create(['name' => 'eliminar_equilibrio']);

        Permission::create(['name' => 'listado_factura']);
        Permission::create(['name' => 'listado_e_factura']);
        Permission::create(['name' => 'ver_factura']);
        Permission::create(['name' => 'actualizar_factura']);
        Permission::create(['name' => 'crear_factura']);
        Permission::create(['name' => 'eliminar_factura']);

        Permission::create(['name' => 'listado_mes']);
        Permission::create(['name' => 'ver_mes']);
        Permission::create(['name' => 'actualizar_mes']);
        Permission::create(['name' => 'crear_mes']);
        Permission::create(['name' => 'eliminar_mes']);

        Permission::create(['name' => 'listado_moneda']);
        Permission::create(['name' => 'listado_e_moneda']);
        Permission::create(['name' => 'ver_moneda']);
        Permission::create(['name' => 'actualizar_moneda']);
        Permission::create(['name' => 'crear_moneda']);
        Permission::create(['name' => 'eliminar_moneda']);

        Permission::create(['name' => 'listado_nota']);
        Permission::create(['name' => 'crear_nora']);
        Permission::create(['name' => 'ver_nota']);
        
        Permission::create(['name' => 'listado_orden']);
        Permission::create(['name' => 'listado_e_orden']);
        Permission::create(['name' => 'ver_orden']);
        Permission::create(['name' => 'actualizar_orden']);
        Permission::create(['name' => 'crear_orden']);
        Permission::create(['name' => 'eliminar_orden']);

        Permission::create(['name' => 'listado_producto']);
        Permission::create(['name' => 'listado_e_producto']);
        Permission::create(['name' => 'ver_producto']);
        Permission::create(['name' => 'actualizar_producto']);
        Permission::create(['name' => 'crear_producto']);
        Permission::create(['name' => 'eliminar_producto']);

        Permission::create(['name' => 'listado_proveedor']);
        Permission::create(['name' => 'listado_e_proveedor']);
        Permission::create(['name' => 'ver_proveedor']);
        Permission::create(['name' => 'actualizar_proveedor']);
        Permission::create(['name' => 'crear_proveedor']);
        Permission::create(['name' => 'eliminar_proveedor']);

        Permission::create(['name' => 'listado_tproducto']);
        Permission::create(['name' => 'listado_e_tproducto']);
        Permission::create(['name' => 'ver_tproducto']);
        Permission::create(['name' => 'actualizar_tproducto']);
        Permission::create(['name' => 'crear_tproducto']);
        Permission::create(['name' => 'eliminar_tproducto']);

        Permission::create(['name' => 'listado_tmpc']);
        Permission::create(['name' => 'listado_e_tmpc']);
        Permission::create(['name' => 'ver_tmpc']);
        Permission::create(['name' => 'actualizar_tmpc']);
        Permission::create(['name' => 'crear_tmpc']);
        Permission::create(['name' => 'eliminar_tmpc']);

        Permission::create(['name' => 'listado_unidad']);
        Permission::create(['name' => 'listado_e_unidad']);
        Permission::create(['name' => 'ver_unidad']);
        Permission::create(['name' => 'actualizar_unidad']);
        Permission::create(['name' => 'crear_unidad']);
        Permission::create(['name' => 'eliminar_unidad']);

        //Permisos para configuraciones
        Permission::create(['name' => 'ver_empresa']);
        Permission::create(['name' => 'crear_empresa']);

        Permission::create(['name' => 'ver_facturac']);
        Permission::create(['name' => 'crear_facturac']);
        
        Permission::create(['name' => 'ver_venta']);
        Permission::create(['name' => 'crear_venta']);
        
        Permission::create(['name' => 'ver_region']);
        Permission::create(['name' => 'crear_region']);

        Permission::create(['name' => 'ver_roles']);

        $admin = Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Visitante']);

        $admin->givePermissionTo([
            
        'listado_ajuste',
        'ver_ajuste',
        'actualizar_ajuste',
        'crear_ajuste',
        'eliminar_ajuste',
        'listado_cliente',
        'listado_e_cliente',
        'ver_cliente',
        'actualizar_cliente',
        'crear_cliente',
        'eliminar_cliente',
        'listado_compra',
        'listado_e_compra',
        'ver_compra',
        'actualizar_compra',
        'crear_compra',
        'eliminar_compra',
        'listado_configuracion',
        'ver_configuracion',
        'actualizar_configuracion',
        'crear_configuracion',
        'eliminar_configuracion',
        'listado_cotizacion',
        'listado_e_cotizacion',
        'ver_cotizacion',
        'actualizar_cotizacion',
        'crear_cotizacion',
        'eliminar_cotizacion',
        'listado_dolar',
        'listado_e_dolar',
        'ver_dolar',
        'actualizar_dolar',
        'crear_dolar',
        'eliminar_dolar',
        'listado_equilibrio',
        'ver_equilibrio',
        'actualizar_equilibrio',
        'crear_equilibrio',
        'eliminar_equilibrio',
        'listado_factura',
        'listado_e_factura',
        'ver_factura',
        'actualizar_factura',
        'crear_factura',
        'eliminar_factura',
        'listado_mes',
        'ver_mes',
        'actualizar_mes',
        'crear_mes',
        'eliminar_mes',
        'listado_moneda',
        'listado_e_moneda',
        'ver_moneda',
        'actualizar_moneda',
        'crear_moneda',
        'eliminar_moneda',
        'listado_nota',
        'crear_nora',
        'ver_nota',
        'listado_orden',
        'listado_e_orden',
        'ver_orden',
        'actualizar_orden',
        'crear_orden',
        'eliminar_orden',
        'listado_producto',
        'listado_e_producto',
        'ver_producto',
        'actualizar_producto',
        'crear_producto',
        'eliminar_producto',
        'listado_proveedor',
        'listado_e_proveedor',
        'ver_proveedor',
        'actualizar_proveedor',
        'crear_proveedor',
        'eliminar_proveedor',
        'listado_tproducto',
        'listado_e_tproducto',
        'ver_tproducto',
        'actualizar_tproducto',
        'crear_tproducto',
        'eliminar_tproducto',
        'listado_tmpc',
        'listado_e_tmpc',
        'ver_tmpc',
        'actualizar_tmpc',
        'crear_tmpc',
        'eliminar_tmpc',
        'listado_unidad',
        'listado_e_unidad',
        'ver_unidad',
        'actualizar_unidad',
        'crear_unidad',
        'eliminar_unidad',
        'ver_empresa',
        'crear_empresa',
        'ver_facturac',
        'crear_facturac',
        'ver_venta',
        'crear_venta',
        'ver_region',
        'crear_region',
        'ver_roles',
        ]);
    }
}
