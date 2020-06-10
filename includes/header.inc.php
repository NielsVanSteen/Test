<?php 
if (file_exists(dirname(__FILE__) . '/../../nav.php')){
    include dirname(__FILE__) . '/../../nav.php';
} else {
    
?>
    
<header class="header">
    <div class="inner-header">
        <div class="inner-header-logo-container">
            <img class="inner-header-logo-image" src="<?php echo LinkUrl::LINKURL ?>images/logo.png" alt="Logo">
            <a class="inner-header-logo-text" href="https://www.digon.be">Digon</a>
        </div>
    </div>
</header>

<?php 
}
?>