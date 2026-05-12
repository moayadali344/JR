const header = document.querySelector(".header")
const hero = document.querySelector(".hero")
const productalk = document.querySelector(".product-go-here")
const userdash = document.querySelector(".user-dashboard-container")
const logincontainer = document.querySelector(".main-login")
const checkoutcard= document.querySelector("#checkoutmain")


try {
           checkoutcard.style.marginTop = header.getClientRects()[0].height  + "px"
                      checkoutcard.style.marginBottom = header.getClientRects()[0].height  *2 + "px"



}catch(e){}



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

 console.log("lll")

try {
const fropdown = document.querySelector(".dropdown");
const profile = document.querySelector(".profile");




profile.addEventListener("click", function (e) {
      console.log("S")

e.stopPropagation(); // The event never reaches the body
fropdown.classList.toggle("active")


if(fropdown.classList.contains("active")){
document.body.addEventListener("click", function () {


  fropdown.classList.remove("active");
},{once:true})


}


})

// click outside → close dropdown


} catch (error) {
  console.log("Error details:", error.message, error.stack)}


  try{
      const logoutBtn = document.getElementById("logout-btn");

if (logoutBtn) {
  logoutBtn.addEventListener("click", function (e) {

    e.preventDefault();


    fetch("/api/logout.php", {
      method: "POST",
      credentials: "include"
    })
    .then(() => {

      // clear sessionStorage
      sessionStorage.removeItem("user");

      // redirect
      window.location.href = "./index.html";

    });

  });
}
  }
  catch(e){

  }