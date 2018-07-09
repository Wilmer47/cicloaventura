<?php

include_once 'Database.php';
include_once 'AlquilerCompleto.php';

class ModelAlquilerCompleto {
    public function getCompletos() {

        $pdo = Database::connect();
        $sql = "select * from tbl_detalle_alqui; select * from tbl_alquiler";
        $resultado = $pdo->query($sql);
        $listado = array();
        foreach ($resultado as $dato) {
            $deta = new AlquilerCompleto();
            $deta->getId_alqui($dato['id_alqui']);
            $deta->getId_cli($dato['id_cli']);
            $deta->getId_emp($dato['id_emp']);
            $deta->setId_coche($dato['id_coche']);
            $deta->setTiempo_ini($dato['tiempo_ini']);
            $deta->setTiempo_fin($dato['tiempo_fin']);
            $deta->setValor($dato['valor']);
            array_push($listado, $deta);
        }
        Database::disconnect();
        return $listado;
    }

    public function getCompleto($id) {

        $pdo = Database::connect();
        $sql = "select * from tbl_detalle_alqui where id_deta_alqui=?";
        $consulta = $pdo->prepare($sql);
        $consulta->execute(array($id));
        $dato = $consulta->fetch(PDO::FETCH_ASSOC);
        $deta = new AlquilerCompleto();
            $deta->getId_alqui($dato['id_alqui']);
            $deta->getId_cli($dato['id_cli']);
            $deta->getId_emp($dato['id_emp']);
            $deta->setId_coche($dato['id_coche']);
            $deta->setTiempo_ini($dato['tiempo_ini']);
            $deta->setTiempo_fin($dato['tiempo_fin']);
            $deta->setValor($dato['valor']);
        Database::disconnect();
        return $deta;
    }

    public function crearCompleto($id_alqui,$id_cli,$id_emp,$id_coche,$tiempo_ini,$tiempo_fin,$valor) {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "insert into tbl_alquiler(id_alqui,id_cli,id_emp,id_coche,tiempo_ini,tiempo_fin,valor) values(0,?,?,?,?,?,'?');";
        $consulta = $pdo->prepare($sql);
        try {
            $consulta->execute(array($id_alqui,$id_cli,$id_emp,$id_coche,$tiempo_ini,$tiempo_fin,$valor));
        } catch (PDOException $e) {
            Database::disconnect();
            throw new Exception($e->getMessage());
        }
        Database::disconnect();
    }

    public function eliminarCompleto($id) {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "delete from tbl_alquiler where id_alqui=?";
        $consulta = $pdo->prepare($sql);
        $consulta->execute(array($id));
        Database::disconnect();
    }

    public function actualizarCompleto($id_alqui,$id_cli,$id_emp,$id_coche,$tiempo_ini,$tiempo_fin,$valor) {
        $pdo = Database::connect();
        $sql = "update tbl_alquiler set id_cli=?,id_emp=? id_coche=?,tiempo_ini=?,tiempo_fin=?,valor=? where id_alqui=?";
        $consulta = $pdo->prepare($sql);
        try {
            $consulta->execute(array($id_alqui,$id_cli,$id_emp,$id_coche,$tiempo_ini,$tiempo_fin,$valor));
        } catch (PDOException $e) {
            Database::disconnect();
            throw new Exception($e->getMessage());
        }
        Database::disconnect();
    }
    
//    public function adicionarDetalle($id_coche,$tiempo_ini,$tiempo_fin,$valor){
//        //buscamos el producto:
//        $deta = new AlquilerCompleto();
//        $crudModel=new CrudModel();
//        $producto=$crudModel->getProducto($idProducto);
//        //creamos un nuevo detalle FacturaDet:
//        $facturaDet=new FacturaDet();
//        $facturaDet->setIdProducto($producto->getIdProducto());
//        $facturaDet->setNombreProducto($producto->getNombre());
//        $facturaDet->setCantidad($cantidad);
//        $facturaDet->setPrecio($producto->getPrecio());
//        $facturaDet->setPorcentajeIva($producto->getPorcentajeIva());
//        $facturaDet->setSubtotal($cantidad * $producto->getPrecio());
//        //adicionamos el nuevo detalle al array en memoria:
//        if(!isset($listaFacturaDet)){
//            $listaFacturaDet=array();
//        }
//        array_push($listaFacturaDet,$facturaDet);
//        return $listaFacturaDet;
//    }
}
