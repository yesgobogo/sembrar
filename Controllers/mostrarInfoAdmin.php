<?php

    // ESTE ARCHIVO RECIBE TODAS LAS CONSULTAS DEL MODELO PARA MOSTRAR INFORMACIÓN AL ADMINISTRADOR
    
    // ESTA FUNCIÓN ES LA QUE SE LLAMA EN LA VISTA

    function cargarUsuarios(){

        $objConsultas = new Consultas();
        $result = $objConsultas->mostrarUsersAdmin();

        if (!isset($result)) {
            echo '<h2>NO HAY USUARIOS REGISTRADOS</h2>';
        }
        else{

            foreach ($result as $f) {
                echo '
                <tr>
                    <td><img src="../'.$f['foto'].'" alt="Foto User" style="width: 60px; height: 60px; border-radius:50%"></td>
                    <td>'. $f['nombres'] .'</td>
                    <td>'.$f['apellidos'].'</td>
                    <td>'.$f['rol'].'</td>
                    <td> '.$f['estado'].' </td>
                    <td><a href="modificar-usuario.php?id='.$f['identificacion'].'" class="btn btn-primary"><i class="ti-pencil-alt"></i> Editar</a></td>
                    <td><a href="../../Controllers/eliminarUserAdmin.php?id='.$f['identificacion'].'" class="btn btn-danger"><i class="ti-trash"></i> Eliminar</a></td>
                </tr>    
                ';
            }

        }

    }

    function cargarUsuarioEditar(){
        // Aterrizamos la PK enviada desde la tabla
        $id_user = $_GET['id'];
        // Enviamos la PK a una función de la clase consultas
        $objConsultas = new Consultas();
        $result = $objConsultas->mostrarUserAdmin($id_user);
        // Pintamos la información consultada en el artefacto(FORM)

        foreach ($result as $f) {
            echo  '
            
            <form action="../../Controllers/actualizarUserAdmin.php" method="POST">

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Identificacion:</label>
                    <input type="number" value="'.$f['identificacion'].'"  class="form-control" readonly placeholder="Ej: 1070782156" name="identificacion">
                </div>
                <div class="form-group col-md-6">
                    <label>Tipo de Documento:</label>
                    <select name="tipo_doc" id="" class="form-control" >
                        <option value="'.$f['tipo_doc'].'" >'.$f['tipo_doc'].'</option>
                        <option value="CC">CC</option>
                        <option value="CE">CE</option>
                        <option value="PASAPORTE">PASAPORTE</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>Nombres:</label>
                    <input type="text" value="'.$f['nombres'].'" class="form-control" placeholder="Ej: Miguel Angel" name="nombres">
                </div>
                <div class="form-group col-md-6">
                    <label>Apellidos:</label>
                    <input type="text" value="'.$f['apellidos'].'" class="form-control" placeholder="Ej: Gallego Restrepo" name="apellidos">
                </div>
                <div class="form-group col-md-6">
                    <label>Email:</label>
                    <input type="email" value="'.$f['email'].'" class="form-control" placeholder="Ej: miguel@gmail.com" name="email">
                </div>
                <div class="form-group col-md-6">
                    <label>Teléfono:</label>
                    <input type="number" value="'.$f['telefono'].'" class="form-control" placeholder="Ej: 32123443322" name="telefono">
                </div>
                
                <div class="form-group col-md-6">
                    <label>Rol:</label>
                    <select name="rol" id="" class="form-control" >
                        <option value="'.$f['rol'].'">'.$f['rol'].'</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Vendedor">Vendedor</option>
                        <option value="Cliente">Cliente</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label>Estado:</label>
                    <select name="estado" id="" class="form-control" >
                    <option value="'.$f['estado'].'">'.$f['estado'].'</option>
                        <option value="Activo">Activo</option>
                        <option value="Pendiente">Pendiente</option>
                        <option value="Bloqueado">Bloqueado</option>
                    </select>
                </div>


            </div>



            <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">MODIFICAR</button>

            </form>
            
            
            ';
        }

    }

    function cargarUsuariosReportes(){

        $objConsultas = new Consultas();
        $result = $objConsultas->mostrarUsersAdmin();

        if (!isset($result)) {
            echo '<h2>NO HAY USUARIOS REGISTRADOS</h2>';
        }
        else{

            foreach ($result as $f) {
                echo '
                <tr>
                    <td> '.$f['identificacion'].' </td>
                    <td>'. $f['nombres'] .'</td>
                    <td>'.$f['apellidos'].'</td>
                    <td>'.$f['email'].'</td>
                    <td>'.$f['telefono'].'</td>
                    <td>'.$f['rol'].'</td>
                    <td> '.$f['estado'].' </td>                    
                </tr>    
                ';
            }

        }

    }

    function perfil(){
        // Variable de sesión del login
        // session_start();
        $id = $_SESSION['id'];

        $objConsultas = new Consultas();
        $result = $objConsultas->verPerfil($id);

        foreach ($result as $f) {
            
            echo '

            <li class="label">'.$f['rol'].'</li>
            <li>
                <a class="sidebar-sub-toggle">
                    <img src="../'.$f['foto'].'" style="width:50px;border-radius:50%"> '.$f['nombres'] .'
                    
                    <span class="sidebar-collapse-icon ti-angle-down"></span>
                </a>
                <ul>
                    <li>
                        <a href="perfil.php?id='.$f['identificacion'].'">
                            <i class="ti-marker-alt"></i>Tu cuenta</a>
                    </li>
                    <li>
                        <a href="../../Controllers/cerrarSesion.php">
                            <i class="ti-close"></i>Cerrar Sesión</a>
                    </li>
                </ul>
            </li>
            
            
            
            ';

        }


    }

    function perfilEditar(){

        $id = $_GET['id'];

        $objConsultas = new Consultas();
        $result = $objConsultas->verPerfil($id);

        foreach ($result as $f) {
            
            echo '
                
            <section id="main-content">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card perfil-user">
                        <img src="../'.$f['foto'].'" alt="">
                        <h2>'.$f['nombres'].' '.$f['apellidos'].'</h2>
                        <h3>'.$f['rol'].'</h3>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card modificar-user">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Perfil</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Cambiar Foto</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contact-tab" data-toggle="tab" data-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Cambiar Clave</button>
                        </li>
                    </ul>
                        <div class="tab-content" id="myTabContent">


                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                                <form action="../../Controllers/modificarCuentaAdmin.php" method="POST" enctype="multipart/form-data">

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Identificacion:</label>
                                            <input type="number" class="form-control" value="'.$f['identificacion'].'" readonly placeholder="Ej: 1070782156" name="identificacion">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Tipo de Documento:</label>
                                            <select name="tipo_doc" id="" class="form-control" >
                                                <option value="'.$f['tipo_doc'].'">'.$f['tipo_doc'].'</option>
                                                <option value="CC">CC</option>
                                                <option value="CE">CE</option>
                                                <option value="PASAPORTE">PASAPORTE</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Nombres:</label>
                                            <input type="text" class="form-control" value="'.$f['nombres'].'" placeholder="Ej: Miguel Angel" name="nombres">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Apellidos:</label>
                                            <input type="text" class="form-control" value="'.$f['apellidos'].'" placeholder="Ej: Gallego Restrepo" name="apellidos">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Email:</label>
                                            <input type="email" class="form-control" value="'.$f['email'].'" placeholder="Ej: miguel@gmail.com" name="email">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Teléfono:</label>
                                            <input type="number" class="form-control" value="'.$f['telefono'].'" placeholder="Ej: 32123443322" name="telefono">
                                        </div>
                                        
                                    </div>



                                    <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Actualizar Datos de la Cuenta</button>

                                </form>

                            </div>


                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                                <form action="../../Controllers/modificarFotoAdmin.php" method="POST" enctype="multipart/form-data">

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Identificacion:</label>
                                            <input type="number" class="form-control" value="'.$f['identificacion'].'" readonly placeholder="Ej: 1070782156" name="identificacion">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Foto:</label>
                                            <input type="file" accept=".jpg, .png, .jpeg, .gif"  class="form-control" placeholder="Ej: 1070782156" name="foto" required="required">
                                        </div>                                                                               
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Actualizar Foto</button>
                                </form>

                            </div>


                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">

                                <form action="../../Controllers/modificarClaveAdmin.php" method="POST" enctype="multipart/form-data">

                                    <div class="row">

                                        <div class="form-group col-md-6">
                                            <label>Identificacion:</label>
                                            <input type="number" class="form-control" value="'.$f['identificacion'].'" readonly placeholder="Ej: 1070782156" name="identificacion">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Nueva Clave:</label>
                                            <input type="password"  class="form-control" placeholder="Ej:*******" name="clave" >
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Confirmar Clave:</label>
                                            <input type="password"  class="form-control" placeholder="Ej:*******" name="clave2" >
                                        </div>
                                        
                                        
                                    </div>



                                    <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Actualizar Clave</button>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="footer">
                        <p>2023 © Admin Board. - <a href="#">Sembrar</a></p>
                    </div>
                </div>
            </div>
        </section>
            
            ';

        }

    }


?>