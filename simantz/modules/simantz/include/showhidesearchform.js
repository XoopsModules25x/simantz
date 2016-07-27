function showSearchForm(){
        jQuery("#divSearch").toggle('fast');
        if(document.getElementById("showHideSearchButton")){
            if(document.getElementById("showHideSearchButton").value=="Show Search Form")
                document.getElementById("showHideSearchButton").value="Hide Search Form";
            else
                document.getElementById("showHideSearchButton").value="Show Search Form";

        }
}