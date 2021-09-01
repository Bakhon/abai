export const langPage = document.documentElement.lang;
export const currentUrlPage = window.location.pathname;
export const urlLink = (url)=>{
    if(typeof url === "string"&&url.length){
        return (`/${langPage+url}`).trim();
    }
}
