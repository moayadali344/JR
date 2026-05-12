const header = document.querySelector(".header")
const hero = document.querySelector(".hero")
const productalk = document.querySelector(".product-go-here")
const userdash = document.querySelector(".user-dashboard-container")
const logincontainer = document.querySelector(".main-login")



try {
           userdash.style.marginTop = header.getClientRects()[0].height * 2 + "px"

} catch (error) {
     
}


 try {
      hero.style.marginTop = header.getClientRects()[0].height + "px"


  
 } catch (error) {
    
 }


 try{

  productalk.style.marginTop =  header.getClientRects()[0].height + "px"
 }
 catch(e){}



 try {
       logincontainer.style.marginTop =  header.getClientRects()[0].height *2 + "px"

 } catch (error) {
     
 }