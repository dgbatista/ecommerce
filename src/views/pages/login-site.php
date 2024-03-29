<?=$render('site/header', [
    'loggedUser' => $loggedUser ?? false, 
    'qtd_itens' => $cart[1]['total'],
    'total_cart'=> $cart[1]['freight']['total']
]); ?>

<div class="product-big-title-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-bit-title text-center">
                    <h2>Autenticação</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="single-product-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">                
            <div class="col-md-6">
                <?php if($flashLogin!=''): ?>
                    <div class="alert alert-danger">
                        <?=$flashLogin;?>
                    </div>
                <?php endif; ?>

                <form action="<?=$base;?>/login" id="login-form-wrap" class="login" method="post">
                    <h2>Acessar</h2>
                    <p class="form-row form-row-first">
                        <label for="login">E-mail <span class="required">*</span>
                        </label>
                        <input type="text" id="login" name="login" class="input-text">
                    </p>
                    <p class="form-row form-row-last">
                        <label for="senha">Senha <span class="required">*</span>
                        </label>
                        <input type="password" id="senha" name="password" class="input-text">
                    </p>
                    <div class="clear"></div>
                    <p class="form-row">
                        <input type="submit" value="Login" class="button">
                        <label class="inline" for="rememberme"><input type="checkbox" value="forever" id="rememberme" name="rememberme"> Manter conectado </label>
                    </p>
                    <p class="lost_password">
                        <a href="<?=$base;?>/forgot">Esqueceu a senha?</a>
                    </p>

                    <div class="clear"></div>
                </form>                    
            </div>
            <div class="col-md-6">
                
                <?php if($flash!=''): ?>
                    <div class="alert alert-danger">
                        <?=$flash;?>
                    </div>
                <?php endif; ?>

                <form id="register-form-wrap" action="<?=$base;?>/register" class="register" method="post">
                    <h2>Criar conta</h2>
                    <p class="form-row form-row-first">
                        <label for="nome">Nome Completo <span class="required">*</span>
                        </label>
                        <input type="text" id="nome" name="name" class="input-text" value="<?=$registerValues['desperson'];?>">
                    </p>
                    <p class="form-row form-row-first">
                        <label for="email">E-mail <span class="required">*</span>
                        </label>
                        <input type="email" id="email" name="email" class="input-text" value="<?=$registerValues['desemail'];?>">
                    </p>
                    <p class="form-row form-row-first">
                        <label for="phone">Telefone
                        </label>
                        <input type="text" id="phone" name="phone" class="input-text" value="<?=$registerValues['nrphone'];?>">
                    </p>
                    <p class="form-row form-row-last">
                        <label for="senha">Senha <span class="required">*</span>
                        </label>
                        <input type="password" id="senha" name="password" class="input-text">
                    </p>
                    <div class="clear"></div>

                    <p class="form-row">
                        <input type="submit" value="Criar Conta" name="login" class="button">
                    </p>

                    <div class="clear"></div>
                </form>               
            </div>
        </div>
    </div>
</div>

<?=$render('site/footer'); ?>