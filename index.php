<?php
    include("includes/head.php");
    require_once("classes/parser.php");
    require_once("classes/database.php");
    
    $db = Database::getDatabase();
?>
<ul class="nav nav-tabs" role="tablist">
	<li class="disabled"><a href="#">Visualisation fichier Joe.txt</a></li>
	<li class="active"  ><a href="index.php">Accueil</a></li>
	<li                 ><a href="albums.php">Liste des Albums</a></li>
	<li                 ><a href="titles.php">Liste des Morceaux</a></li>
</ul>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Accueil Joe.txt<br><br>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive" id="index_table" >
                        <div class="panel panel-default">
                            <div class="btn-group btn-group-justified" role="group" aria-label="...">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-default" onclick="startParse()" >Lancer le parseur</button>
                                </div>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-default" onclick="deleteTablesAction()" >Supprimer les tables</button>
                                </div>
                            </div>
                        </div>
                        <center>
                            <div id="id_success" style="display:none;" class="alert alert-success" role="alert">...</div>
                            <div id="id_danger"  style="display:none;" class="alert alert-danger" role="alert">...</div>
                        </center>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<?php
    include("includes/footer.php");
?>
