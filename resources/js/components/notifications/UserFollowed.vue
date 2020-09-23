<template>
	<p><a href="#" class="text-blue-500 hover:underline" v-text="notification.data.name"></a> is now following you</p>
</template>

<script>
	export default {
		props: ["notification"]
	}
</script>