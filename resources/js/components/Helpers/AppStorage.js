class AppStorage{
    storeToken(token){
        return localStorage.setItem('token',token);
    }
    clear(){
        localStorage.removeItem('token');
    }
    getToken(){
        return localStorage.getItem('token');
    }
}

export default AppStorage = new AppStorage()