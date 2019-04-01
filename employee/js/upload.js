$(function()
    {
        var ss = document.getElementsByTagName('img');
        var newimgheight=389;
        var newimgwidth=200;    
        if(ss.length>0)
        {
            newimgheight=ss[0].height;
            newimgwidth=ss[0].width;
        }    
        var input = document.getElementById("images"), 
        formdata = false;
       
        function showUploadedItem (source,ids) {            
            var list = document.getElementById("image-list"),
            li = document.createElement("li");
            li.id='i_'+ids;
            /*imgdelete=document.createElement("img");
			imgdelete.className="deleteimg";
			imgdelete.title="Delete Image";
			imgdelete.alt="Delete Image"
			imgdelete.src="image/delete-icon.png";
			imgdelete.style.width= '30px';
			imgdelete.style.height= '30px';
			li.appendChild(imgdelete);*/		
			
            img  = document.createElement("img");			
            img.id='200px';
            img.style.width= newimgwidth+'px';
            img.style.height= newimgheight+'px';
            img.src = source;			
            li.appendChild(img);
            list.appendChild(li);
			
            insertdiv=document.createElement("div");
            insertdiv.style.clear= 'both';			
            li.appendChild(insertdiv);
			
            idelete=document.createElement("i");
            idelete.className="icon-remove deleteimg";
            idelete.title="Delete Image";	
            idelete.id=ids;
            li.appendChild(idelete);
			
        }   

        if (window.FormData) {
            //formdata = new FormData();            
            //document.getElementById("btn").style.display = "none";
        }
        var allfiles;
        var len;
        input.addEventListener("change", function (evt) 
        {		
            document.getElementById("response").innerHTML = "Uploading . . ."
            formdata = new FormData();
            var i = 0, len = this.files.length, img, reader, file;
            for (; i < len; i++) {
                file = this.files[i];
                if (!!file.type.match(/image.*/)) {                    
                    if (formdata) {
                        formdata.append("images[]", file);
                        allfiles=file;
                    }
                }	
            }
	
            if (formdata) {
                //alert(allfiles);
                var pid=$('#pid').val();
                var n;                
                $.ajax({
                    url: "process/processImageUpload.php?pid="+pid,
                    type: "POST",
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success: function (res) {               
                        n=res.split(",");                         
                        var insertids=1;
                        for (i = 0 ; i < len; i++ ) {                                                                                    
                            file = input.files[i];
                            if ( window.FileReader ) {
                                reader = new FileReader();
                                reader.onloadend = function (e) {                                     
                                    showUploadedItem(e.target.result, n[insertids++]);                                                                      
                                };
                                reader.readAsDataURL(file);
                            }                            
                        }
                        $("#uniform-images span.filename").text('No file selected');                        
                        $("#uniform-images span.action").text('Choose File');                        
                        //$('#uniform-images').remove();                        
                        //$("#images").replaceWith("<input type='file' name='images' multiple id='images'/>").html();
                        document.getElementById("response").innerHTML = "Uploading Sucessfuly"
                        
                    }                
                });
            }
        }, false);
    });

