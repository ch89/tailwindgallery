<template>
	<p><a href="#" class="text-blue-500 hover:underline" v-text="notification.data.name"></a> commented on photo <a href="#" class="text-blue-500 hover:underline" v-text="notification.data.photo.title"></a></p>
</template>

<script>
	export default {
		props: ["notification"]
	}
</script>