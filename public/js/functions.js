/****************************************************************/
// Funciones
/****************************************************************/

// Si el documento se cierra, se elimina la cookie almacenada
/*var preguntar = true;
     
window.onbeforeunload = preguntarAntesDeSalir;

function preguntarAntesDeSalir(){
  if(preguntar){
	  cookie.remove("token");
	  return "¿Seguro que quieres salir de AsBuilt?";
  }
}*/


var socketConnected = false;
var currentToken = 1;
var socket = {};
var handlers = {};
var usuario ={};

var login_handler = {};
var connected_handler = {};
var disconnected_handler = {};

var s3 = {};

var credentials = {};

function sendCommand(command, data, handler){
	if(socketConnected){
		data['token'] = currentToken;
		data['func'] = command;
		if(handler != 0){
			handlers[''+currentToken] = handler;
		}
		currentToken++;
		socket.emit("client_to_api", JSON.stringify(data));
		return true;
	}
	return false;
}

function getAwsCredentials(){
    sendCommand("getAwsIdentity", {}, function(data){
	if(data["ack"]==true){

	    usuario["aws_identity"] = data["resp"]["IdentityId"];

	    credentials = new AWS.CognitoIdentityCredentials({
		IdentityPoolId: 'us-east-1:362cbecf-f607-4cba-81d0-1a5965b46e7e',
		IdentityId: data["resp"]["IdentityId"],
		Logins: {
		    'cognito-identity.amazonaws.com': data["resp"]["Token"],
		}
	    });

	    credentials.expired = false

	    console.log(JSON.stringify(credentials));

	    AWS.config.update({
		region: 'us-east-1',
		credentials: credentials
	    });

	    s3 = new AWS.S3({
		apiVersion: '2006-03-01',
		region: 'us-west-2',
		credentials: credentials,
		params: {Bucket: 'asbuilt0'}
	    });
	}
    });
}
function uuidv4() {
  return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
    var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
    return v.toString(16);
  });
}

function file_thumb(file,where){
    var reader = new FileReader();
    
    reader.onload = (function(theFile) {
	    var URL = window.webkitURL || window.URL;
	    var url = URL.createObjectURL(theFile);
	    var img = new Image();
	    img.src = url;
	    
	    img.onload = function() {

		img_width = img.width;
		img_height = img.height;
		var canvas = document.createElement('canvas');
		var h = img_width>img_height ? (384.0 * img_height)/img_width:384 ;
		var w = img_width>img_height ? 384.0 :(384.0* img_width)/img_height;
		canvas.width = w;
		canvas.height = h;
		where.innerHTML = '';
		where.appendChild(canvas);
		var ctx = canvas.getContext('2d');
		ctx.drawImage(img,0,0,w,h);
		
	    }
    })(file);
    
    reader.readAsDataURL(file);

}
function create_thumb_to_upload(file,thumb_handler){
    var reader = new FileReader();
    
    reader.onload = (function(theFile) {
	    var URL = window.webkitURL || window.URL;
	    var url = URL.createObjectURL(theFile);
	    var img = new Image();
	    img.src = url;
	    img.onload = function() {

		img_width = img.width;
		img_height = img.height;
		var canvas = document.createElement('canvas');
		var h = img_width>img_height ? (384.0 * img_height)/img_width:384 ;
		var w = img_width>img_height ? 384.0 :(384.0* img_width)/img_height;
		canvas.width = w;
		canvas.height = h;
		var ctx = canvas.getContext('2d');
		ctx.drawImage(img,0,0,w,h);
		canvas.toBlob(thumb_handler, "image/jpeg", 0.9);
	    }
    })(file);
    
    reader.readAsDataURL(file);
}

function perform_upload_final(file,key,upload_result_handler,upload_progress_handler){
    
    if(typeof(upload_progress_handler) != 'undefined'){
	s3.upload({
	    Bucket : 'asbuilt0',
	    Key: key,
	    Body: file
	}, upload_result_handler).on('httpUploadProgress',upload_progress_handler);
    }else{
	s3.upload({
	    Bucket : 'asbuilt0',
	    Key: key,
	    Body: file
	}, upload_result_handler);
    }    
}

function upload_file(file,upload_result_handler,upload_progress_handler) {

    console.log(file.name);

    var fl_type = file.type.startsWith("image")?"0":(file.type.startsWith("video")?1:2);
    var uid = uuidv4();
    var key = usuario["aws_identity"] + "/" + fl_type + "/" + file.type + "/" + uid + "." + file.name.split('.').pop();
    console.log("esta es la key:" + key);
    
    if(file.type.startsWith("image")){
	create_thumb_to_upload(file,function(thumb_blob){
	    perform_upload_final(thumb_blob,key+"_t",function(err, data) {
		if (err) {
		    upload_result_handler(err,data);
		}else{
		    perform_upload_final(file,key,upload_result_handler,upload_progress_handler);
		}
	    });
	    
	});
    }else{
	perform_upload_final(file,key,upload_result_handler,upload_progress_handler);
    }
    
}

function download_file(key,url_got_handler){
    s3.getSignedUrl('getObject',
		    {Bucket: 'asbuilt0',
		     Key: key },
		    url_got_handler
		   );
}
function login_user(email,password_raw,login_result){

	console.log(email);
	console.log(password_raw);

	var password =  SHA256(password_raw);
	console.log(password);

    sendCommand("login", {user_email: email,password: password}, function(data){
	if(data["ack"] == true){
	    cookie.set({token: data["token_access"]}, 
			{expires: 1,path: "/"});
	    sendCommand("getUser",{}, function(data2){
		usuario = data2["resp"][0];
		getAwsCredentials();
		if(typeof(login_result) != 'undefined'){
		    login_result(true);
		}
	    });
	}
	 else {
	     if(typeof(login_result) != 'undefined'){
		    login_result(false);
		}
	 }
	
    });
}

function logout(){
    cookie.remove("token");
}
function token_login(token){
    sendCommand("tokenLogin", {user_token_access: token}, function(data){
	if(data["ack"]==true){
	    sendCommand("getUser",{}, function(data2){
		usuario = data2["resp"][0];
		getAwsCredentials()
	    });
	}
    });
}

function asbuilt_load(){
    socket = io.connect('http://52.33.14.171:3000', {'forceNew':true});
    socket.on('connect', function(){
	socketConnected = true;
	console.log("Conectado");
	if(cookie.get("token") != undefined){
	    
	    var token = cookie.get("token");
	    
	    token_login(token);
	    
	}
    });
    
    socket.on('disconnect', function(){
	socketConnected = false;
	console.log("Desconectado");
    });

    socket.on('client_to_api', function(data){
	var datos = JSON.parse(data);

	if(typeof(datos.token) != 'undefined' && typeof(handlers[''+datos.token]) != 'undefined'){
	    console.log("RESPONSE : \n"+data);
	    handlers[''+datos.token](datos);
	    delete handlers[''+datos.token];
	}
    });



}
