<h1><?php echo $auth_name; ?></h1>
<section>
    <label>
        <input type="password" placeholder="密碼" :model="password">
    </label>
    <i class="fa-solid fa-eye-slash" @click="show"></i>
</section>
<button @click="auth_login" style="z-index: 1000;">
    前往
    <i class="fa-solid fa-arrow-right"></i>
</button>