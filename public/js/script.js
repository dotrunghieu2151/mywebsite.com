window.onload = () => {
    const firstPageURL = window.location.href; 
    const pages = document.querySelectorAll(".webpage");
    const loadingAni = document.querySelector(".loading-wrapper");
    const pageContent = document.querySelector(".page-content");
    function activeState(element){
        let activeEle = document.querySelector("#active");
        activeEle != null ? activeEle.removeAttribute("id") : '';
        element.setAttribute("id","active");
    };
    function get(url,data) {
        return new Promise((resolve, reject) => {
          loadingAni.style.display = "block";
          const req = new XMLHttpRequest();
          req.open('POST', url);
          req.setRequestHeader('Content-type','application/x-www-form-urlencoded'); 
          req.onload = () => req.status === 200 ? resolve(req.response) : reject(Error(req.statusText));
          req.onerror = (e) => reject(Error(`Network Error: ${e}`));
          req.send("getData="+JSON.stringify(data));
        })
                .then((res) => {
                    loadingAni.style.display = "none";
                    return JSON.parse(res);
        })
                .catch(error => console.log(error) );
                
    }
    async function loadPage(url){
        pageContent.innerHTML = '';
        pageContent.appendChild(loadingAni);
        let response =  await get(url, "ajax");
        document.title = response.pageTitle;
        pageContent.innerHTML = response.html;       
    }
    for (let page of pages) {
        page.addEventListener("click", function(e){
            e.preventDefault();
            activeState(this);
            if (this.href != window.location.href) {
               loadPage(this.href);
               window.history.pushState({path:this.href},null,this.href);
            }               
        });
    }
    window.addEventListener("popstate", function(e){
        previousPath = ( e.state == null ?  firstPageURL : e.state.path);
        previousActive = document.querySelector(`a[href="${previousPath}"]`);
        activeState(previousActive);
        loadPage(previousPath);
    });
};

