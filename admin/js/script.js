setTimeout(function(){
    let alertMessage  = document.querySelectorAll('.alert');
    alertMessage.forEach(function(message){
        message.style.display='none';
    });
},2000);
