<!-- Left navbar-header -->
<div class="navbar-default sidebar" role="navigation">

    <div class="sidebar-nav navbar-collapse slimscrollsidebar">

        <ul class="nav" id="side-menu">
            <li class="user-pro">
                <a href="#" class="waves-effect">
                    <img src="assets/images/common/users.png" 
                        alt="user-img" 
                        class="img-circle"> 
                        <span class="hide-menu">
                            <?=$_SESSION['congresso_nome']?>
                        <span class="fa arrow"></span>
                    </span>
                </a>
                <ul class="nav nav-second-level">
                    <li><a id="mudarsenha" href="javascript:void(0)"><i class="ti-key"></i> Mudar senha</a></li>
                    <li><a id="sair" href="javascript:void(0)"><i class="fa fa-power-off"></i> Sair</a></li>
                </ul>
            </li>
            <li class="nav-small-cap m-t-10">Funções</li>

            <li> 
                <a href="<?=($_SESSION['congresso_gestor'] == 1 ? '/administrador/dashboard' : '/office/dashboard')?>" 
                    class="waves-effect">
                    <i class="linea-icon linea-basic fa-fw" data-icon="v"></i> 
                    <span class="hide-menu"> Dashboard </span>
                </a>
            </li>

            <?php if(isset($_SESSION['congresso_gestor']) && $_SESSION['congresso_gestor'] == 1){ ?>
                <li> 
                    <a href="/administrador/pagamento" class="waves-effect">
                        <i class="ti-money fa-fw" data-icon="v"></i> <span class="hide-menu"> Pagamentos </span>
                    </a>
                </li>
                <li> 
                    <a href="/administrador/cliente" class="waves-effect">
                        <i class="icon-people fa-fw" data-icon="v"></i> <span class="hide-menu"> Clientes </span>
                    </a>
                </li>
                <li> 
                    <a href="/administrador/lote" class="waves-effect">
                        <i class="icon-layers fa-fw" data-icon="v"></i> <span class="hide-menu"> Lotes </span>
                    </a>
                </li>
                <li> 
                    <a href="/administrador/deficiencia" class="waves-effect">
                        <i class="fa fa-wheelchair" data-icon="v"></i> <span class="hide-menu"> Deficiência </span>
                    </a>
                </li>
            <?php } ?>

            <?php if(isset($_SESSION['congresso_gestor']) && $_SESSION['congresso_gestor'] != 1){ ?>
                <li> 
                    <a href="/office/cliente/edit/<?=$_SESSION['congresso_uid']?>" 
                        class="waves-effect">
                        <i class="icon-user" data-icon="v"></i> <span class="hide-menu"> Meu perfil </span>
                    </a>
                </li>
            <?php } ?>

        </ul>
    </div>
</div>
<!-- Left navbar-header end -->