<?php
    include("includes/head.php");
    require_once("classes/parser.php");
    require_once("classes/database.php");
    
    $db = Database::getDatabase();
?>
<ul class="nav nav-tabs" role="tablist">
	<li class="disabled"><a href="#">Visualisation fichier Joe.txt</a></li>
	<li                 ><a href="index.php">Accueil</a></li>
	<li class="active"  ><a href="albums.php">Liste des Albums</a></li>
	<li                 ><a href="titles.php">Liste des Morceaux</a></li>
</ul>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default" id="albums">
                <div class="panel-heading">
                    Liste des Albums<br><br>
                    <label for="search">Recherche par Nom/Date : </label>
                    <input type="text" class="form-control search" name="search" id="search" />
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive" id="index_table" >
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th class="sort" data-sort="id"  >Id</th>
                                    <th class="sort" data-sort="name">Nom</th>
                                    <th class="sort" data-sort="date">Date</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <?php		
                                    $albumsListReq = $db->prepare('SELECT id, name, date FROM albums');
                                    $albumsListReq->execute(array());

                                    foreach ($albumsListReq as $row)
                                    {
                                        ?>
                                        <tr class="odd gradeX">
                                            <td class="id">  <?php echo $row['id']; ?>   </td>
                                            <td class="name"><a href="titles.php?search=<?php echo $row['name']; ?>"><?php echo $row['name']; ?></a></td>
                                            <td class="date"><?php echo $row['date']; ?> </td>
                                        </tr>
                                        <?php
                                    }
                                ?>
                            </tbody>
                        </table>
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

<script>
    var options = {
        valueNames: [ 'id', 'name', 'date' ]
    };

    var albumList = new List('albums', options);
</script>