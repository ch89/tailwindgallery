<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>App</title>
	<link rel="stylesheet" href="/css/app.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
</head>
<body>
	<div id="app" class="antialiased text-gray-800">
		<navbar @modal="show = true"></navbar>

		<modal v-show="show" @close="close" title="Create Photo">
			{{-- Without image --}}
			{{-- <form id="photo-form" @submit.prevent="add">
				<div class="mb-4">
					<label for="title" class="form-label">Title</label>
					<input type="text" class="form-input" id="title" v-model="form.title">
				</div>
				<div>
					<label for="content" class="form-label">Content</label>
					<input type="text" class="form-input" id="content" v-model="form.content">
				</div>
			</form> --}}

			{{-- With image --}}
			<form id="photo-form" @submit.prevent="addWithImage" ref="photo-form">
				<div class="mb-4">
					<label for="title" class="form-label">Title</label>
					<input type="text" class="form-input" :class="{ 'border-red-500': errors.title }" id="title" name="title">
					<p class="error" v-if="errors.title" v-text="errors.title[0]"></p>
				</div>
				<div class="mb-4">
					<label for="content" class="form-label">Content</label>
					<input type="text" class="form-input" :class="{ 'border-red-500': errors.content }" id="content" name="content">
					<p class="error" v-if="errors.content" v-text="errors.content[0]"></p>
				</div>
				<div class="mb-4">
					<label for="channel_id" class="form-label">Content</label>
					<select name="channel_id" id="channel_id" class="form-input">
						<option v-for="channel in channels" :value="channel.id" v-text="channel.name"></option>
					</select>
					<p class="error" v-if="errors.content" v-text="errors.content[0]"></p>
				</div>
				<div>
					<label for="image" class="form-label">Image</label>
					<input type="file" class="block w-full" id="image" name="image">
					<p class="error" v-if="errors.image" v-text="errors.image[0]"></p>
				</div>
			</form>

			{{-- <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-4" v-if="errors">
				<ul class="list-disc pl-4">
					<li v-for="error in errors" v-text="error[0]"></li>
				</ul>
			</div> --}}

			<button class="btn btn-blue font-bold mr-2" form="photo-form" slot="footer">Add</button>
		</modal>

		{{-- <comments-modal v-if="photo"></comments-modal> --}}

		<comments v-if="photo"></comments>
		
		<main class="container mx-auto p-6">
			<transition name="router-view" mode="out-in">
				<router-view></router-view>
			</transition>
		</main>

		<flash></flash>
	</div>

	<script src="/js/app.js"></script>
</body>
</html>