const userId = localStorage.getItem('sessionID');
if(userId){
    window.location.href = '/';
}