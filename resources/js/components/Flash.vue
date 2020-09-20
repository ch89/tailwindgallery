<template>
	<transition-group name="flash" tag="div" class="fixed bottom-8 right-8 z-10">
		<div class="alert" :class="`alert-${message.type}`" v-for="message in messages" :key="message.id">
			<strong class="font-bold">{{ capitalize(message.type) }}!</strong>
			<span v-text="message.text"></span>
		</div>
	</transition-group>
</template>

<script>
	import { mapState } from "vuex"

	export default {
		computed: mapState("flash", ["messages"]),
		methods: {
			capitalize(str) {
				return str[0].toUpperCase() + str.slice(1)
			}
		}
	}
</script>

<style scoped>
	.alert:not(:last-child) {
		margin-bottom: 1rem;
	}

	.alert {
		transition: 1s;
	}

	.flash-enter, .flash-leave-to {
		opacity: 0;
	}
</style>