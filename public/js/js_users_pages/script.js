 $(document).ready(function(){
    $('.slider').slider();
    
    var coll = document.getElementsByClassName("collapsiblemod");
    var i;
    console.log(coll);
    for (i = 0; i < coll.length; i++) {
      coll[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var content = document.getElementById('mod'+this.getAttribute('data-id'));
          content.style.display = 'block';
        if (content.style.maxHeight){
          content.style.maxHeight = null;
            setTimeout(function(){ content.style.display = 'none'; }, 200);
        } else {
          content.style.maxHeight = content.scrollHeight + "px";
        } 
      });
    }
     
});
