<head>
    <meta charset="UTF-8">
    <title> AsBuilt </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('/css/all.css') }}" rel="stylesheet" type="text/css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="{{ asset('/js/jquery.sha256.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/socket.io.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/cookie.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/aws-sdk-2.169.0.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/functions.js') }}" type="text/javascript"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script>
        //See https://laracasts.com/discuss/channels/vue/use-trans-in-vuejs
        window.trans = @php
            // copy all translations from /resources/lang/CURRENT_LOCALE/* to global JS variable
            $lang_files = File::files(resource_path() . '/lang/' . App::getLocale());
            $trans = [];
            foreach ($lang_files as $f) {
                $filename = pathinfo($f)['filename'];
                $trans[$filename] = trans($filename);
            }
            $trans['adminlte_lang_message'] = trans('adminlte_lang::message');
            echo json_encode($trans);
        @endphp
    </script>


    <script>
 // Check for FileReader support
 if (window.FileReader && window.Blob) {

     /* Handle local files */
     $("#file").on('change', function(event) {
     var file = event.target.files[0];
     if (file.size >= 32 * 1024 * 1024) {
         alert("File size must be at most 2MB");
         return;
     }
     $("hr").after($("#file_rep").text("FILE MIME type: " + file.type));
     if(file.type.startsWith("image")){
         file_thumb(file,document.getElementById('file_rep'));
     }else{
         document.getElementById('file_rep').innerHTML = 'NOT AN IMAGE';
     }
     });

 } else {
     // File and Blob are not supported
     $("hr").after( $("<div>").text("It seems your browser doesn't support FileReader") );
 } /* Drakes, 2015 */

</script>

<script>

</script>

<script>


 $(document).ready(function(){



  


    $('.tab-nav span').on('click', function() {
      $([$(this).parent()[0], $($(this).data('href'))[0]]).addClass('active').siblings('.active').removeClass('active');
    });

     asbuilt_load();
     if(cookie.get("token") != undefined){
     
     console.log("COOKIE EXISTS");
     
     }else{
     console.log("NO COOKIE");
     }
     $("#login_btn").click(function(){
    

     console.log("loggin...");
     console.log($("#user").val());
     console.log($("#pass").val());
     login_user($("#user").val(),$("#pass").val(),function(did_it){
         console.log("LOGGED : "+did_it);
         $("#form-login").submit()
     });
     return false;
     });


     $(".target").submit(function(evt){

     	var formulario = $(this).attr('name');
     	
   
        evt.preventDefault(); 

        
     if(document.getElementById('file-'+formulario).files.length>0){
         console.log("uploading...");
         var file = document.getElementById('file-'+formulario).files[0];
         if (file.size >= 32 * 1024 * 1024) {
         alert("File size must be at most 32MB");
         return;
         }
         upload_file(file,
             function(err, data) {
                 if (err) {
                 console.log(JSON.stringify(err));
                 return alert('There was an error uploading: ', err.message);
                 }
               

                 $.ajaxSetup({
				    headers: {
				        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				    }
				});

                 			var form = document.forms.namedItem(formulario); // high importance!, here you need change "yourformname" with the name of your form
							var formdata = new FormData(form); // high importance!
							formdata.append('nombre_imagen',data.key);
                            console.log("nombre llave "+data.key);
                            var desde = $('form[name='+formulario+']>input:hidden[name=desde]').val();
                            if(desde=="proyecto"){
                                var idenviada =$('form[name='+formulario+']>input:hidden[name=idproyecto]').val()
                            }

                            if(desde=="planta"){
                                var idenviada =$('form[name='+formulario+']>input:hidden[name=idplanta]').val()
                            }

                            if(desde=="piso"){
                                var idenviada =$('form[name='+formulario+']>input:hidden[name=idpiso]').val()
                            }

                            if(desde=="sala"){
                                var idenviada =$('form[name='+formulario+']>input:hidden[name=idsala]').val()
                            }

                            $.ajax({
					            url: "http://52.33.14.171/public/subirdoc",
					            method: $("form[name="+formulario+"]").attr("method"),
					            data: formdata,
					            async: true,
							    cache: false,
							    contentType: false,
							    processData: false,
					            dataType: 'json',
					            success: function(res)
					            {
					                if(res.message)
					                {
					                $(".success-"+res.desde+"-"+res.id).html('');

					                $(".success-"+res.desde+"-"+res.id).html('<div class="alert alert-success alert-dismissible" style="margin-bottom: 0px; float: left; margin-left: 0px; margin-bottom: 20px; width: 100%"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Se Ha subido el archivo correctamente</div>');
					                	
					                }
					            },
					            error: function(jqXHR, textStatus, errorThrown)
					            {
                                    
					                if(jqXHR)
					                {

                                        $(".success-"+desde+"-"+idenviada).html('');

					                    var errors = jqXHR.responseJSON;

					                    var html = "<div class='alert alert-danger'>";

					                    for(error in errors)
					                    {
					                        html+="<p>" + errors[error] + "</p>";
					                    }

					                    html += "</div>";

					                    $(".success-"+desde+"-"+idenviada).html(html);
					                }
					            }
					        })
					    



             },
             function(evt) {
                 console.log("Uploaded :: " + parseInt((evt.loaded * 100) / evt.total)+'%');
             }
         );
     }
     return false;
     });
     $("#download_btn").click(function(){
     console.log("GETTING URL FOR : " + $("#download_file").val());
     download_file(document.getElementById('download_file').value,
               function (err, url) {
               if(err){
                   console.log(JSON.stringify(err));
               }else{
                   console.log('The URL is', url);
               }
               });
     return false;
     });
 });


 
</script>
</head>
