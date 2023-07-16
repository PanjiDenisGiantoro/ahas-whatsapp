<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

                   <label class="form-label">Image</label>
                   <div class="input-group ">
                        <span class="input-group-btn">
                            <a  class="btn btn-primary text-white imagetest" data-bs-toggle="modal" data-bs-target="#pilihFileSayang" onclick="handleHidden()">
                                <i class="fa fa-file-o"></i> Pilih
                            </a>
                        </span>
                            <input id="test-media-file-1" class="form-control" type="text" name="image" required="">
                    </div>
                    <label for="caption" class="form-label">Caption</label>
                    <textarea type="text" name="caption" class="form-control" id="caption" required> </textarea>

                    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
  $('#image').filemanager('file')
</script>
                  