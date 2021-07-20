<template>
    <div class="container-fluid mt-4">
        <user-password></user-password>
    </div>
</template>

<script>
    import UserPassword from "./Settings/UserPassword";

    export default {
        components: {
            UserPassword,
        },
    };
</script>