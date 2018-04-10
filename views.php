<?php


// print "<pre>";
// print_r($selects);
// print "</pre>";
// // die();

// foreach($table_fields as $field){ 
//     for($i=0;$i<sizeof($selects[$field]); $i++){
//         print $selects[$field][$i];
//     }
// }
// // // // var_dump(array_keys($selects));
// die();
?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <title>Table</title>
  </head>
  <body>
  <div class="container-fluid">
      <!-- Button trigger modal -->
      <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-4">
                 <form action="index.php" method="get">
                    Page: <input type="text" name="from"><br>
                    <input type="submit" value="Fetch">
                </form>
            </div>
            <div class="col-sm-12 col-md-4">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="index.php?page=<?php echo $current-1; ?>">Previous</a></li>
                    <li class="page-item"><a class="page-link" href="index.php?page=<?php echo $current+1; ?>">Next</a></li>
                </ul>
                </nav>
            </div>
              <div class="col-sm-12 col-md-4">
                <button type="button" class="btn btn-primary" id='click' data-toggle="modal" data-target="#exampleModal">
                Filter
                </button>
                <a class='btn btn-danger' type='button' href='index.php?page=-1'>Reset</a>
             </div>
        </div>
     </div>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content"> 
                            <form action="index.php" name="form" method="POST">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Filters</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                        <div class="modal-body">
                             <div class="container">
                                    <?php 
                                    foreach($table_fields as $field){ 
                                       ?>
                                <div class="row">
                                    <div class="col-md-4 col-sm-6"><?php echo $field; ?></div>
                                    <div class="col-md-8 col-sm-6">
                                        <div class="form-group">
                                        <select class='js-example-basic-multiple' name="<?php echo $field; ?>[]" multiple="multiple"style="width:100%;max-width:90%;">
                                            <?php 
                                            if(in_array($field ,array_keys($selects))){
                                                for($i=0;$i<sizeof($selects[$field]); $i++){ ?>
                                                <option value='<?php echo $selects[$field][$i]; ?>'><?php echo $selects[$field][$i]; ?></option>
                                          <?php } 
                                          }
                                          ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                    <?php } ?>
                                </div>
                                <script>
                                $(document).ready(function() {
                                     $('.js-example-basic-multiple').select2();
                                        });
                                        </script>
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Filter!</button>
                        </div>
                             </form>
                        </div>
                    </div>
                </div>
         <div class="table-responsive">
             <table class="table table-striped">
                <thead>
                    <tr>
                        <?php foreach($table_fields as $field){ ?>
                             <th scope="col"><?php echo $field; ?></th>
                        <?php } ?>
                    </tr>
                 </thead>
                <tbody>
                    <tr>
                         <?php foreach($results as $row){
                                foreach($table_fields as $field){ ?>
                                     <td> <?php echo $row[$field]; ?></td>
                                 <?php } ?>
                             </tr>
                        <?php } ?>
                     </tbody>
                 </table>
                 </div>

                    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $('#exampleModal').modal('hide');


$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});

    $(document).ready(function() {
    $('#goapptiv_table').DataTable({
        "pagingType": "simple",
        deferRender:    true,
        select:         true,
        responsive:     true,
        scrollY:        800,
        scrollX:        800,
        scroller:       true,
    });
} );
</script>
  </body>
</html>