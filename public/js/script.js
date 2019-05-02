window.onload = () => {
    const firstPageURL = window.location.href; 
    const firstActiveEle = $(".active");
    const pages = document.querySelectorAll(".webpage");
    const loadingAni = document.querySelector(".loading-wrapper");
    const pageContent = document.querySelector(".page-content");
    function activeState(element){
        let activeEle = document.querySelector(".active");
        activeEle != null ? activeEle.classList.remove("active") : '';
        element.classList.add("active");
    };
    function $(selector) {
        return document.querySelector(selector);
    };
    function get(url,data,method) {
        return new Promise((resolve, reject) => {
          const req = new XMLHttpRequest();
          req.open(method, url);
          req.setRequestHeader('Content-type','application/x-www-form-urlencoded'); 
          req.onload = () => req.status === 200 ? resolve(req.response) : reject(Error(req.statusText));
          req.onerror = (e) => reject(Error(`Network Error: ${e}`));
          req.send("getData="+JSON.stringify(data));
        })
                .then((res) => {
                    return JSON.parse(res);
        })
                .catch(error => console.log(error) );
                
    }
    async function loadPage(url,direction = "forward",data = "ajax",method="POST"){
       if(direction === "forward") {
           if(url != window.location.href) {
                loadingAni.style.display = "block";
                pageContent.innerHTML = '';
                pageContent.appendChild(loadingAni);
                let response =  await get(url,data,method);
                loadingAni.style.display = "none";
                document.title = response.pageTitle;
                pageContent.innerHTML = response.html;
                window.history.pushState({path:url,activelink:$(".active").id},null,url);
            }
        }
        else if (direction === "back") {
            pageContent.innerHTML = '';
            pageContent.appendChild(loadingAni);
            let response =  await get(url,data,method);
            document.title = response.pageTitle;
            pageContent.innerHTML = response.html;
        }
    }
    window.addEventListener("popstate", function(e){
        previousPath =  e.state == null ?  firstPageURL : e.state.path;
        previousActive = e.state == null ? firstActiveEle : $(`#${e.state.activelink}`);
        activeState(previousActive);
        loadPage(previousPath,"back");
    });
    for (let page of pages) {
        page.addEventListener("click", function(e){
            e.preventDefault();
            activeState(this);
            loadPage(this.href);          
        });
    }
    pageContent.addEventListener("click", function(e){
       if (e.target.classList.contains("restaurant-detail")){
           e.preventDefault();
           let restaurantURL = e.target.href;
           loadPage(restaurantURL);
        }
        if (e.target.classList.contains("pagination-link")) {
            e.preventDefault();
            let paginationURL = e.target.href;
            loadPage(paginationURL);
        }
    });
    $("#search-form").addEventListener("submit",function(e){
       e.preventDefault();
       let searchInput = $("#search-input").value;
       let url = searchInput === "" ?  
       `http://localhost:81/mywebsite.com/restaurants` : `http://localhost:81/mywebsite.com/restaurants/search/${searchInput}`;
       activeState($("#restaurant"));
       loadPage(url);
    });
    $("#search-input").addEventListener("input", async function(e){
        if (this.value === "") {return false;}
        let url = "http://localhost:81/mywebsite.com/ajax/autocomplete";
        let response = await get(url,this.value,"POST");
        console.log(response.output);
        $(".search-container").appendChild(response.output);
    });
    function autocomplete(e){
        $("#search-input").value = e.target.value;
    }
};
