<template>
    <div>
        hello
    </div>
</template>
<script>
export default {
    mounted() {
        const currentUrl = window.location.href;
        const path = window.location.pathname;
        window.opener.postMessage(currentUrl, 'http://localhost:5173/callback/login');
    }
}
</script>