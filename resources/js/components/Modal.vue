<template>
	<transition name="modal">
		<div class="overlay absolute z-50 inset-0 bg-black bg-opacity-50 flex justify-center items-center">
			<div class="modal bg-white rounded-lg w-1/3">
				<div class="flex justify-between items-center p-6">
					<h3 class="font-bold text-lg">{{ title }}</h3>
					<button class="focus:outline-none" @click="$emit('close')">
						<i class="fas fa-times"></i>
					</button>
				</div>
				<div class="p-6 border-t border-b border-gray-300 max-h-lg overflow-auto">
					<slot></slot>
				</div>
				<div class="p-6 flex justify-end">
					<slot name="footer"></slot>
					<!-- <button class="btn btn-red mr-2">Add</button> -->
					<button class="btn btn-secondary font-bold" @click="$emit('close')">Close</button>
				</div>
			</div>
		</div>
	</transition>
</template>

<script>
	export default {
		props: ["title"]
	}
</script>

<style scoped>
	.overlay {
		transition: opacity .5s;
	}

	.modal {
		transition: transform .5s;
	}

	.modal-enter, .modal-leave-to {
		opacity: 0
	}

	.modal-enter .modal, .modal-leave-to .modal {
		transform: scale(1.1);
	}
</style>