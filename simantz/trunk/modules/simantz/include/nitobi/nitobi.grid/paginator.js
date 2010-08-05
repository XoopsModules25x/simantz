var Pager = {    
    //PageSize:10,
    CurrentPage:0,
    TotalPages:0,
    TotalRows:0,
    Last:function(GridID) {
        Pager.CurrentPage = Pager.TotalPages;
        Pager.BindToGrid(GridID);
    },
    First:function(GridID) {
        Pager.CurrentPage = 1;
        Pager.BindToGrid(GridID);
    },
    Previous:function(GridID) {
        if (Pager.CurrentPage > 1) {
            Pager.CurrentPage--;
        } else {
            Pager.CurrentPage = Pager.TotalPages;
        }
        Pager.BindToGrid(GridID);
    },
    Next:function(GridID) {
        if (Pager.CurrentPage < Pager.TotalPages) {
            Pager.CurrentPage++;
        } else {
            Pager.CurrentPage = 1;
        }
        Pager.BindToGrid(GridID);
    },
    Reset:function(GridID) {
        Pager.CurrentPage = 0;
        Pager.TotalPages = 0;
        Pager.BindToGrid(GridID);
    },
    // Uses the paging variables in the Pager object to re-bind the Grid with the right page.
    BindToGrid:function(GridID) {
        g = nitobi.getComponent(GridID);
        //var grid = nitobi.getGrid("DataboundGrid");
        if (Pager.TotalPages == 0) {
            g.datatable.setGetHandlerParameter('StartRecord',0);
        } else {
            g.datatable.setGetHandlerParameter('StartRecord',(Pager.CurrentPage-1)*Pager.PageSize);
        }
        
        g.loadingScreen.show();
        g.dataBind();
    }
}
function HandleReady(eventArgs) {
	var g = eventArgs.source;
    Pager.TotalRows = parseInt(g.datatable.handlerError);
    if(g.datatable.handlerError == null)
    Pager.TotalRows = 0;

    Pager.PageSize = document.getElementById('totalRowGrid').value;

    Pager.TotalPages = Math.ceil(Pager.TotalRows/Pager.PageSize);

    //$('pager_total').innerHTML = Pager.TotalPages;
    document.getElementById('pager_total').innerHTML = Pager.TotalPages;

    if (Pager.TotalPages > 0) {
        if (Pager.CurrentPage == 0) {
            Pager.CurrentPage = 1;
        }
    } else {
        Pager.CurrentPage = 0;
    }

    //$('pager_current').innerHTML = Pager.CurrentPage;
    document.getElementById('pager_current').innerHTML = Pager.CurrentPage;
    document.getElementById('totalRecord').innerHTML = "Total Record Found : "+Pager.TotalRows;
    
    // Hide Grid loading screen.
    g.loadingScreen.hide();
}