
<div class="main-container ace-save-state" id="main-container">
    <script type="text/javascript">
        try{ace.settings.loadState('main-container')}catch(e){}
    </script>

    <div id="sidebar" class="sidebar                  responsive                    ace-save-state">
        <script type="text/javascript">
            try{ace.settings.loadState('sidebar')}catch(e){}
        </script>

        <div class="sidebar-shortcuts" id="sidebar-shortcuts">
            <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                <button class="btn btn-success">
                    <i class="ace-icon fa fa-signal"></i>
                </button>

                <button class="btn btn-info">
                    <i class="ace-icon fa fa-pencil"></i>
                </button>

                <button class="btn btn-warning">
                    <i class="ace-icon fa fa-users"></i>
                </button>

                <button class="btn btn-danger">
                    <i class="ace-icon fa fa-cogs"></i>
                </button>
            </div>

            <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                <span class="btn btn-success"></span>

                <span class="btn btn-info"></span>

                <span class="btn btn-warning"></span>

                <span class="btn btn-danger"></span>
            </div>
        </div><!-- /.sidebar-shortcuts -->

        <ul class="nav nav-list">
            <li class="active">
                <a href="dashboardhome">
                    <i class="menu-icon fa fa-tachometer"></i>
                    <span class="menu-text"> Dashboard </span>
                </a>

                <b class="arrow"></b>
            </li>
            <!--foreach($sidemenu as $menu)-->
            <?php 
            use Illuminate\Support\Facades\DB;
$result =DB::select("SELECT DISTINCT(name),id FROM modules WHERE isActive=1 order by orders asc");
foreach($result as $row)
{     echo "<li class=''>
                <a href='#' class='dropdown-toggle'>
                    <i class='menu-icon fa fa-folder'></i>
                   
                    <span class='menu-text'>
                      $row->name
                    </span>

                    <b class='arrow fa fa-angle-down'></b>
                </a>

                <b class='arrow'></b>
                
                <ul class='submenu'>";
    $result1 = DB::select("SELECT * FROM requirements WHERE isActive=1 AND module_id=$row->id ");
    // Access Rights 
    if(auth()->user()->isAccess==1){
        foreach($result1 as $row1)
        {
         echo "<li class=''>
                                <a href='$row1->Urls' >
                                    <i class='menu-icon fa fa-caret-right'></i>
        
                                   $row1->name
                                    
                                </a>
        
                                <b class='arrow'></b>
                            </li>";
        }
    }else{

        foreach($result1 as $row1)
        {
            if($row->id==1){
         echo "<li class=''>
                                <a href='$row1->Urls' >
                                    <i class='menu-icon fa fa-caret-right'></i>
        
                                   $row1->name
                                    
                                </a>
        
                                <b class='arrow'></b>
                            </li>";
            }
        }
    }

    echo "</li></ul>";
} ?>
           
        </ul>
       
<!-- /.nav-list -->

        <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
            <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
        </div>
    </div>

    <div class="main-content">
        <div class="main-content-inner">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <i class="ace-icon fa fa-home home-icon"></i>
                        <a href="#">Home</a>
                    </li>
                    <li class="active">Dashboard</li>
                </ul><!-- /.breadcrumb -->

                <div class="nav-search" id="nav-search">
                    <form class="form-search">
                        <span class="input-icon">
                            <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                            <i class="ace-icon fa fa-search nav-search-icon"></i>
                        </span>
                    </form>
                </div><!-- /.nav-search -->
            </div>
