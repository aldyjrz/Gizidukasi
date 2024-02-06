<?php
$id = $_GET['id'];

$q = mysqli_query($koneksi, "select * from tbl_artikel where id = '$id'");
$data= mysqli_fetch_array($q);

?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/43.0.1/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<main role="main" class="col-md-12 ml-sm-auto col-lg-12 px-md-4 mt-5">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12 col-sm-10">

                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-4">Form Laporan Gizi Makanan Anak</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
            <div class="col-md-6">
                <form action="edit_article.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input value='<?= $data['judul']?>' type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="image">Image: <img width='50px' src=' <?= $data['img']?>'/> </label>
                        <input value='<?= $data['img']?>' type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
                    </div>
               
            </div>

                 <div class="col-md-12  mt-3">
                     <div class="form-group">
                        <label for="content">Article Content:</label>
                        <textarea  name="content" id="content"   ><?= $data['isi']?></textarea>
                    </div>
                    <input value='<?= $id ?>' type="hidden"  name="id_artikel"  >

                    <button type="submit" class="btn btn-primary mt-5">Submit</button>
                </form>
            </div>
        </div>
                    </div>
                </div>
 
                </div>
            </div>
        </div>

    </div>
    </div>
    </div>
</main>
</section>

<!-- Custom JS -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
<script>
                        ClassicEditor
                                .create( document.querySelector( '#content' ) )
                                .then( editor => {
                                        console.log( editor );
                                } )
                                .catch( error => {
                                        console.error( error );
                                } );
                </script>
<script>
    // Initialize DataTable
    $(document).ready(function() {

        $('#giziTable').DataTable({
            dom: 'Bfrtip',
            buttons: ['excel', 'pdf']
        });


    });
</script>