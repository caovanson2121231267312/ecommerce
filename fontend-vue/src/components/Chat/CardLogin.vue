<template>
    <div class="card cs-400 border-bottom-0 border-danger">
        <div class="card-header d-flex justify-content-between align-items-center p-2 bg-danger">
            <span class="mb-0 text-light cursor-pointer" @click="toggleChat">
                <i class="fas fa-angle-left fs-3"></i>
            </span>
            <div>
                <span class="fw-bold fs-4 text-light">Live Chat</span>
            </div>
            <div>
                <div class="fs-4 text-light" @click="toggleChat">
                    <i class="fas fa-times close-chat"></i>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="p-5">
                <div class="d-flex justify-content-center align-items-center flex-column">
                    <RouterLink class="btn btn-primary ms-2 rounded-1 w-100 my-2" to="/login">
                        Đăng nhập
                    </RouterLink>
                    <RouterLink class="btn btn-outline-danger ms-2 rounded-1 w-100 my-2" to="/signup">
                        Đăng ký
                    </RouterLink>
                    <div>
                        <span>Bạn cần đăng nhập để tiếp tục</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer border-2 border-bottom border-danger">
            <div>Chat với nhân viên tư vấn</div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        toggleChat: {
            type: Function,
            require: true,
        }
    }
}
</script>