<?php
    include("includes/head.php");
    require_once("classes/parser.php");
    require_once("classes/database.php");
    
    $db = Database::getDatabase();
    
    $defaultSearch = "";
    
    if (isset($_GET['search']))
        $defaultSearch = htmlspecialchars($_GET['search']);
?>
<ul class="nav nav-tabs" role="tablist">
	<li class="disabled"><a href="#">Visualisation fichier Joe.txt</a></li>
	<li                 ><a href="index.php">Accueil</a></li>
	<li                 ><a href="albums.php">Liste des Albums</a></li>
	<li class="active"  ><a href="titles.php">Liste des Morceaux</a></li>
</ul>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div id="titles" class="panel panel-default">
                <div class="panel-heading">
                    Liste des Morceaux<br><br>
                    <label for="search">Recherche par Nom/Album/Date : </label>
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
                                    <th class="sort" data-sort="album">Album</th>
                                    <th class="sort" data-sort="date">Date</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <?php		
                                    $titlesListReq = $db->prepare('SELECT titles.id as titleId, titles.name as titleName, albums.name as albumName, albums.date as albumDate FROM titles LEFT JOIN albums ON titles.album_id = albums.id');
                                    $titlesListReq->execute(array());

                                    foreach ($titlesListReq as $row)
                                    {
                                        ?>
                                        <tr class="odd gradeX">
                                            <td class="id">     <?php echo $row['titleId']; ?>   </td>
                                            <td class="name">   <?php echo $row['titleName']; ?> </td>
                                            <td class="album">  <?php echo $row['albumName']; ?> </td>
                                            <td class="date">   <?php echo $row['albumDate']; ?> </td>
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
    $(function()
    {
        var titleList = new List('titles', { valueNames: [ 'id', 'name', 'album', 'date' ] });

        <?php
            if ($defaultSearch != "")
            {
                ?>
                $('#search').val("<?php echo $defaultSearch; ?>");
                titleList.search("<?php echo $defaultSearch; ?>");
                <?php
            }
        ?>
    });
</script>