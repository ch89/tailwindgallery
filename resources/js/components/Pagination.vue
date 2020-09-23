<template>
	<nav class="mt-4 border rounded inline-block">
		<ul class="flex">
			<li>
				<router-link :to="{ query: { ...$route.query, page: photos.current_page - 1 } }" class="block px-4 py-2 hover:bg-gray-200 focus:outline-none" :class="{ 'text-gray-500 pointer-events-none': photos.current_page == 1 || loading }" tabindex="-1">Previous</router-link>
			</li>
			<li>
				<router-link :to="{ query: { ...$route.query, page: photos.current_page + 1 } }" class="block px-4 py-2 border-l hover:bg-gray-200 focus:outline-none" :class="{ 'text-gray-500 pointer-events-none': photos.current_page == photos.last_page || loading }" tabindex="-1">Next</router-link>
			</li>
		</ul>
	</nav>
</template>

<script>
	import { mapState } from "vuex"

	export default {
		computed: mapState("photo", ["photos", "loading"])
	}
</script>