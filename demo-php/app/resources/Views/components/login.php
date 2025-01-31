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
<section :width="100%" :display="flex" :justify-content="center" :align-items="center" :gap="1rem">
    <a href="https://github.com/pardnchiu/web-admin-20241110" target="_blank" :text-decoration="none" :display="flex" :justify-content="center" :align-items="center" :gap="0.5rem">
        <i class="fa-brands fa-github"></i>
        GiuHub
    </a>
</section>