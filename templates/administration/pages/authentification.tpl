<div class="am-wrapper am-login">
    <div class="am-content">
      <div class="main-content">
        <div class="login-container">
          <div class="panel panel-default">
            <div class="panel-heading">
			<img src='/{#logo#}' class='logo' style='width:100px; height:100px'>
			</div>
            <div class="panel-body">
			<span>Veuillez saisir les informations ci-dessous</span>
              <form action="/{$_adminpath}" method="post" class="form-horizontal">
                <div class="login-form">
                  <div class="form-group">
                    <div class="input-group"><span class="input-group-addon"><i class="icon s7-user"></i></span>
                      <input name="username" id="username" type="text" placeholder="Login" autocomplete="off" class="form-control">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group"><span class="input-group-addon"><i class="icon s7-lock"></i></span>
                      <input name="password" id="password" type="password" placeholder="Mot de passe" class="form-control">
                    </div>
                  </div>
                  <div class="form-group login-submit">
                    <button data-dismiss="modal" type="submit" class="btn btn-primary btn-lg">Je m'identifie</button>
                  </div>
                  <div class="form-group footer row">
                    <div class="col-xs-6"><a href="#">Mot de passe oublié?</a></div>
                    <div class="col-xs-6 remember">
                      <label for="remember">Se souvenir de moi</label>
                      <div class="am-checkbox">
                        <input type="checkbox" id="remember" class="needsclick">
                        <label for="remember"></label>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>