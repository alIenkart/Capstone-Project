<template>
    <div class="space-y-8 max-w-[1800px] mx-auto">
        <!-- Introduction Section -->
        <section class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                <h2 class="text-2xl font-bold text-[#1E71B8]">Introduction</h2>
                <input v-model="introSearch" type="text" placeholder="Search Introduction..."
                    class="pl-4 pr-4 py-2 border-2 border-gray-200 rounded-xl focus:border-[#1E71B8] focus:ring-2 focus:ring-[#1E71B8]/20 outline-none sm:min-w-[200px]" />
            </div>

            <div class="space-y-4">
                <div v-for="item in filteredIntroduction" :key="item.id"
                    class="bg-white rounded-2xl shadow-md hover:shadow-xl p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center border border-gray-100 transition-all">
                    <div class="flex-1">
                        <h2 class="text-lg font-bold text-[#1E71B8]">{{ item.title }}</h2>
                        <p class="text-blue-500 font-medium mb-2">{{ item.subtitle }}</p>
                        <p class="text-gray-600 leading-relaxed">{{ item.description }}</p>
                    </div>
                    <div class="flex items-center gap-4 mt-4 sm:mt-0">
                        <div
                            class="w-40 h-24 rounded-xl border border-gray-200 shadow-sm overflow-hidden flex items-center justify-center bg-gray-100">
                            <img v-if="item.image" :src="getImageUrl(item.image)" alt="Thumbnail"
                                class="w-full h-full object-cover" />
                            <span v-else class="text-gray-500 text-sm text-center">No Image Provided</span>
                        </div>
                        <button @click="openEdit(item)"
                            class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors flex items-center justify-center"
                            aria-label="Edit">
                            <svg class="w-5 h-5 text-[#1E71B8] group-hover:text-white transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Travel Blogs Section -->
        <section class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                <h2 class="text-2xl font-bold text-[#1E71B8]">Travel Blogs</h2>
                <div class="flex gap-3">
                    <input v-model="blogSearch" type="text" placeholder="Search blogs..."
                        class="pl-4 pr-4 py-2 border-2 border-gray-200 rounded-xl focus:border-[#1E71B8] focus:ring-2 focus:ring-[#1E71B8]/20 outline-none sm:min-w-[200px]" />
                    <button @click="openAddBlog"
                        class="px-5 py-2 rounded-xl bg-gradient-to-r from-[#1E71B8] to-[#2a8bb5] text-white font-semibold hover:shadow-lg hover:scale-105 transition-all duration-200 flex items-center gap-2 whitespace-nowrap">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Blog
                    </button>
                </div>
            </div>

            <div class="space-y-4">
                <div v-for="blog in filteredBlogs" :key="blog.id"
                    class="bg-white rounded-2xl shadow-md hover:shadow-xl p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center border border-gray-100 transition-all">
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-[#1E71B8]">{{ blog.title }}</h3>
                        <p class="text-blue-500 font-medium mb-2">{{ blog.destination }}</p>
                        <p class="text-gray-600 leading-relaxed mb-2">{{ blog.excerpt }}</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ blog.date }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ blog.author }}
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 mt-4 sm:mt-0">
                        <div
                            class="w-40 h-24 rounded-xl border border-gray-200 shadow-sm overflow-hidden flex items-center justify-center bg-gray-100">
                            <img v-if="blog.image" :src="blog.image" alt="Blog thumbnail"
                                class="w-full h-full object-cover" />
                            <span v-else class="text-gray-500 text-sm text-center">No Image</span>
                        </div>
                        <div class="flex flex-col gap-2">
                            <button @click="openEditBlog(blog)"
                                class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors flex items-center justify-center"
                                aria-label="Edit">
                                <svg class="w-5 h-5 text-[#1E71B8]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <button @click="deleteBlog(blog.id)"
                                class="p-2 rounded-lg bg-red-50 hover:bg-red-100 transition-colors flex items-center justify-center"
                                aria-label="Delete">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-if="filteredBlogs.length === 0" class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    <p class="text-gray-500 font-medium">No travel blogs found</p>
                    <p class="text-gray-400 text-sm mt-1">Add your first travel blog to get started</p>
                </div>
            </div>
        </section>

        <!-- Introduction Edit Modal -->
        <div v-if="showEditModal"
            class="fixed inset-0 bg-gradient-to-br from-black/60 via-black/50 to-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4 animate-fadeIn">
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl relative overflow-hidden animate-slideUp">
                <!-- Header with gradient background -->
                <div class="bg-gradient-to-r from-[#1E71B8] to-[#2a8bb5] px-8 py-6 relative overflow-hidden">
                    <div class="absolute inset-0 bg-white/10 backdrop-blur-sm"></div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-white mb-1">Edit Content</h2>
                            <p class="text-white/80 text-sm">Update your content details and imagery</p>
                        </div>
                        <button @click="closeModal"
                            class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 backdrop-blur-sm flex items-center justify-center transition-all hover:rotate-90 duration-300"
                            aria-label="Close">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Content -->
                <div class="px-8 py-6 max-h-[calc(100vh-200px)] overflow-y-auto custom-scrollbar">
                    <div class="space-y-6">
                        <!-- Image Upload Section -->
                        <div class="space-y-3">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Featured Image
                                </span>
                            </label>
                            <div class="relative group cursor-pointer" @click="pickImage">
                                <div
                                    class="relative w-full h-56 rounded-2xl border-2 border-dashed border-gray-300 overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 transition-all duration-300 group-hover:border-[#1E71B8] group-hover:shadow-lg">
                                    <img v-if="previewImage" :src="previewImage" alt="Preview"
                                        class="w-full h-full object-cover" />
                                    <div v-else
                                        class="absolute inset-0 flex flex-col items-center justify-center text-gray-400">
                                        <svg class="w-16 h-16 mb-3 opacity-40" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="font-medium">No image selected</p>
                                        <p class="text-sm mt-1">Click to upload</p>
                                    </div>
                                </div>
                                <input ref="fileInput" type="file" class="hidden" accept="image/*"
                                    @change="onImageChange" />
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 flex items-center justify-center transition-all duration-300">
                                    <div class="text-center transform group-hover:scale-105 transition-transform">
                                        <svg class="w-12 h-12 text-white mx-auto mb-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <span class="text-white font-semibold text-lg">{{ previewImage ? 'Change Image'
                                            : 'Upload Image' }}</span>
                                        <p class="text-white/80 text-sm mt-1">Click to browse</p>
                                    </div>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 flex items-center gap-1.5 px-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Supported formats: JPG, JPEG, PNG, GIF (Max 2MB)
                            </p>
                        </div>

                        <!-- Form Fields -->
                        <div class="space-y-4">
                            <!-- Title Field -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                        </svg>
                                        Title
                                    </span>
                                </label>
                                <input v-model="editableItem.title" type="text" placeholder="Enter a compelling title"
                                    disabled
                                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3.5 outline-none transition-all text-gray-500 placeholder:text-gray-400 bg-gray-50 cursor-not-allowed" />
                            </div>

                            <!-- Subtitle Field -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                        Subtitle
                                    </span>
                                </label>
                                <input v-model="editableItem.subtitle" type="text"
                                    placeholder="Add a descriptive subtitle"
                                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3.5 focus:border-[#1E71B8] focus:ring-4 focus:ring-[#1E71B8]/10 outline-none transition-all text-gray-800 placeholder:text-gray-400" />
                            </div>

                            <!-- Description Field -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 6h16M4 12h16M4 18h7" />
                                        </svg>
                                        Description
                                    </span>
                                </label>
                                <textarea v-model="editableItem.description" rows="4"
                                    placeholder="Provide a detailed description..."
                                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3.5 focus:border-[#1E71B8] focus:ring-4 focus:ring-[#1E71B8]/10 outline-none transition-all resize-none text-gray-800 placeholder:text-gray-400"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="px-8 py-6 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                    <button @click="closeModal"
                        class="px-6 py-3 rounded-xl font-semibold text-gray-700 border-2 border-gray-300 hover:bg-gray-100 hover:border-gray-400 transition-all duration-200">
                        Cancel
                    </button>
                    <button @click="saveEdit"
                        class="px-6 py-3 rounded-xl bg-gradient-to-r from-[#1E71B8] to-[#2a8bb5] text-white font-semibold hover:shadow-lg hover:scale-105 transition-all duration-200 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Save Changes
                    </button>
                </div>
            </div>
        </div>

        <!-- Travel Blog Add/Edit Modal -->
        <div v-if="showBlogModal"
            class="fixed inset-0 bg-gradient-to-br from-black/60 via-black/50 to-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4 animate-fadeIn">
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl relative overflow-hidden animate-slideUp">
                <!-- Header with gradient background -->
                <div class="bg-gradient-to-r from-[#1E71B8] to-[#2a8bb5] px-8 py-6 relative overflow-hidden">
                    <div class="absolute inset-0 bg-white/10 backdrop-blur-sm"></div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-white mb-1">{{ isEditingBlog ? 'Edit' : 'Add' }} Travel
                                Blog</h2>
                            <p class="text-white/80 text-sm">{{ isEditingBlog ? 'Update your travel blog details' :
                                'Share your travel experience' }}</p>
                        </div>
                        <button @click="closeBlogModal"
                            class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 backdrop-blur-sm flex items-center justify-center transition-all hover:rotate-90 duration-300"
                            aria-label="Close">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Content -->
                <div class="px-8 py-6 max-h-[calc(100vh-200px)] overflow-y-auto custom-scrollbar">
                    <div class="space-y-6">
                        <!-- Image Upload Section -->
                        <div class="space-y-3">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Featured Image
                                </span>
                            </label>
                            <div class="relative group cursor-pointer" @click="pickBlogImage">
                                <div
                                    class="relative w-full h-56 rounded-2xl border-2 border-dashed border-gray-300 overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 transition-all duration-300 group-hover:border-[#1E71B8] group-hover:shadow-lg">
                                    <img v-if="previewBlogImage" :src="previewBlogImage" alt="Preview"
                                        class="w-full h-full object-cover" />
                                    <div v-else
                                        class="absolute inset-0 flex flex-col items-center justify-center text-gray-400">
                                        <svg class="w-16 h-16 mb-3 opacity-40" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="font-medium">No image selected</p>
                                        <p class="text-sm mt-1">Click to upload</p>
                                    </div>
                                </div>
                                <input ref="blogFileInput" type="file" class="hidden" accept="image/*"
                                    @change="onBlogImageChange" />
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 flex items-center justify-center transition-all duration-300">
                                    <div class="text-center transform group-hover:scale-105 transition-transform">
                                        <svg class="w-12 h-12 text-white mx-auto mb-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <span class="text-white font-semibold text-lg">{{ previewBlogImage ? 'Change Image' : 'Upload Image' }}</span>
                                        <p class="text-white/80 text-sm mt-1">Click to browse</p>
                                    </div>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 flex items-center gap-1.5 px-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Supported formats: JPG, JPEG, PNG, GIF (Max 2MB)
                            </p>
                        </div>

                        <!-- Form Fields -->
                        <div class="space-y-4">
                            <!-- Title Field -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                        </svg>
                                        Title
                                    </span>
                                </label>
                                <input v-model="editableBlog.title" type="text" placeholder="Enter blog title"
                                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3.5 focus:border-[#1E71B8] focus:ring-4 focus:ring-[#1E71B8]/10 outline-none transition-all text-gray-800 placeholder:text-gray-400" />
                            </div>

                            <!-- Destination Field -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Destination
                                    </span>
                                </label>
                                <input v-model="editableBlog.destination" type="text" placeholder="Enter destination"
                                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3.5 focus:border-[#1E71B8] focus:ring-4 focus:ring-[#1E71B8]/10 outline-none transition-all text-gray-800 placeholder:text-gray-400" />
                            </div>

                            <!-- Author and Date -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700">
                                        <span class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            Author
                                        </span>
                                    </label>
                                    <input v-model="editableBlog.author" type="text" placeholder="Author name"
                                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3.5 focus:border-[#1E71B8] focus:ring-4 focus:ring-[#1E71B8]/10 outline-none transition-all text-gray-800 placeholder:text-gray-400" />
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700">
                                        <span class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Date
                                        </span>
                                    </label>
                                    <input v-model="editableBlog.date" type="date"
                                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3.5 focus:border-[#1E71B8] focus:ring-4 focus:ring-[#1E71B8]/10 outline-none transition-all text-gray-800" />
                                </div>
                            </div>

                            <!-- Excerpt Field -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 6h16M4 12h16M4 18h7" />
                                        </svg>
                                        Excerpt
                                    </span>
                                </label>
                                <textarea v-model="editableBlog.excerpt" rows="4"
                                    placeholder="Brief description of your travel experience..."
                                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3.5 focus:border-[#1E71B8] focus:ring-4 focus:ring-[#1E71B8]/10 outline-none transition-all resize-none text-gray-800 placeholder:text-gray-400"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="px-8 py-6 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                    <button @click="closeBlogModal"
                        class="px-6 py-3 rounded-xl font-semibold text-gray-700 border-2 border-gray-300 hover:bg-gray-100 hover:border-gray-400 transition-all duration-200">
                        Cancel
                    </button>
                    <button @click="saveBlog"
                        class="px-6 py-3 rounded-xl bg-gradient-to-r from-[#1E71B8] to-[#2a8bb5] text-white font-semibold hover:shadow-lg hover:scale-105 transition-all duration-200 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        {{ isEditingBlog ? 'Update' : 'Add' }} Blog
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import AdminIndex from './AdminIndex.vue'
import { ref, computed, onMounted } from 'vue'
import { isEmpty } from 'lodash'
import { api } from '../../api/api'
import { useToast } from 'vue-toastification'

defineOptions({ layout: AdminIndex })

const service = new api()
const toast = useToast()

const introSearch = ref('')
const blogSearch = ref('')
const showEditModal = ref(false)
const showBlogModal = ref(false)
const isEditingBlog = ref(false)
const fileInput = ref(null)
const blogFileInput = ref(null)
const contents = ref([])
const blogs = ref([])
const previewImage = ref(null)
const previewBlogImage = ref(null)

const filteredIntroduction = computed(() => {
    if (isEmpty(contents.value)) return []
    return contents.value.filter(item =>
        [item.title, item.subtitle, item.description].some(field =>
            field?.toLowerCase().includes(introSearch.value.toLowerCase())
        )
    )
})

const filteredBlogs = computed(() => {
    if (isEmpty(blogs.value)) return []
    return blogs.value.filter(blog =>
        [blog.title, blog.destination, blog.excerpt, blog.author].some(field =>
            field?.toLowerCase().includes(blogSearch.value.toLowerCase())
        )
    )
})

const editableItem = ref({ id: null, title: '', subtitle: '', description: '', image: '' })
const editableBlog = ref({ id: null, title: '', destination: '', excerpt: '', date: '', author: '', image: '' })

const openEdit = (item) => {
    editableItem.value = { ...item }
    previewImage.value = item.image ? getImageUrl(item.image) : null
    showEditModal.value = true
}

const closeModal = () => {
    showEditModal.value = false
    editableItem.value = { id: null, title: '', subtitle: '', description: '', image: '' }
    previewImage.value = null
    if (fileInput.value) fileInput.value.value = null
}

const openAddBlog = () => {
    isEditingBlog.value = false
    editableBlog.value = { id: null, title: '', destination: '', excerpt: '', date: '', author: '', image: '' }
    previewBlogImage.value = null
    showBlogModal.value = true
}

const openEditBlog = (blog) => {
    isEditingBlog.value = true
    editableBlog.value = { ...blog }
    previewBlogImage.value = blog.image
    showBlogModal.value = true
}

const closeBlogModal = () => {
    showBlogModal.value = false
    isEditingBlog.value = false
    editableBlog.value = { id: null, title: '', destination: '', excerpt: '', date: '', author: '', image: '' }
    previewBlogImage.value = null
    if (blogFileInput.value) blogFileInput.value.value = null
}

const pickImage = () => { fileInput.value?.click() }
const pickBlogImage = () => { blogFileInput.value?.click() }

const onImageChange = (e) => {
    const file = e.target.files[0]
    const maxSizeMB = 5
    if (!file) return
    if (file.size > maxSizeMB * 1024 * 1024) {
        toast.error(`File too large! Maximum size is ${maxSizeMB}MB.`)
        e.target.value = null
        return
    }
    previewImage.value = URL.createObjectURL(file)
}

const onBlogImageChange = (e) => {
    const file = e.target.files[0]
    const maxSizeMB = 5
    if (!file) return
    if (file.size > maxSizeMB * 1024 * 1024) {
        toast.error(`File too large! Maximum size is ${maxSizeMB}MB.`)
        e.target.value = null
        return
    }
    previewBlogImage.value = URL.createObjectURL(file)
}

const saveEdit = async () => {
    try {
        const file = fileInput.value?.files?.[0]
        const maxSizeMB = 5

        if (file && file.size > maxSizeMB * 1024 * 1024) {
            toast.error(`File too large! Maximum size is ${maxSizeMB}MB.`)
            return
        }

        const payload = {
            title: editableItem.value.title || '',
            subtitle: editableItem.value.subtitle || '',
            description: editableItem.value.description || ''
        }

        const response = await service.updateContent(editableItem.value.id, payload)

        let finalResponse = response
        if (file) {
            finalResponse = await service.uploadContentImage(editableItem.value.id, file)
            toast.success('Image uploaded successfully!')
        }

        const index = contents.value.findIndex(i => i.id === editableItem.value.id)
        if (index !== -1) {
            contents.value[index] = finalResponse.data
        }

        previewImage.value = finalResponse.data.image ? getImageUrl(finalResponse.data.image) : null
        editableItem.value.image = finalResponse.data.image

        toast.success('Content updated successfully!')
        closeModal()
    } catch (err) {
        console.error(err)
        if (err.response?.data?.errors) {
            const messages = Object.values(err.response.data.errors).flat().join(' ')
            toast.error(messages)
        } else {
            toast.error('Failed to update content.')
        }
    }
}

const saveBlog = async () => {
    if (!editableBlog.value.title || !editableBlog.value.destination) {
        toast.error('Please fill in title and destination')
        return
    }

    try {
        const file = blogFileInput.value?.files?.[0]
        const maxSizeMB = 2

        if (file && file.size > maxSizeMB * 1024 * 1024) {
            toast.error(`File too large! Maximum size is ${maxSizeMB}MB.`)
            return
        }

        if (isEditingBlog.value) {
            const payload = {
                title: editableBlog.value.title,
                destination: editableBlog.value.destination,
                excerpt: editableBlog.value.excerpt || '',
                date: editableBlog.value.date,
                author: editableBlog.value.author
            }

            const response = await service.updateTravelBlog(editableBlog.value.id, payload)

            let finalResponse = response
            if (file) {
                finalResponse = await service.uploadTravelBlogImage(editableBlog.value.id, file)
                toast.success('Image uploaded successfully!')
            }

            const index = blogs.value.findIndex(b => b.id === editableBlog.value.id)
            if (index !== -1) {
                blogs.value[index] = {
                    ...finalResponse.data,
                    image: finalResponse.data.image ? getImageUrl(finalResponse.data.image) : ''
                }
            }

            toast.success('Blog updated successfully!')
        } else {
            const formData = new FormData()
            formData.append('title', editableBlog.value.title)
            formData.append('destination', editableBlog.value.destination)
            formData.append('excerpt', editableBlog.value.excerpt || '')
            formData.append('date', editableBlog.value.date)
            formData.append('author', editableBlog.value.author)
            
            if (file) {
                formData.append('image', file)
            }

            const response = await service.createTravelBlog(formData)
            const newBlog = {
                ...response.data,
                image: response.data.image ? getImageUrl(response.data.image) : ''
            }
            blogs.value.unshift(newBlog)
            toast.success('Blog added successfully!')
        }

        closeBlogModal()
    } catch (err) {
        console.error(err)
        if (err.response?.data?.errors) {
            const messages = Object.values(err.response.data.errors).flat().join(' ')
            toast.error(messages)
        } else {
            toast.error('Failed to save blog.')
        }
    }
}

const deleteBlog = async (id) => {
    if (!confirm('Are you sure you want to delete this blog?')) {
        return
    }

    try {
        await service.deleteTravelBlog(id)
        blogs.value = blogs.value.filter(b => b.id !== id)
        toast.success('Blog deleted successfully!')
    } catch (err) {
        console.error(err)
        toast.error('Failed to delete blog.')
    }
}

const getImageUrl = (path) => {
    if (!path) return ''
    const baseUrl = window.location.origin
    return `${baseUrl}/storage/${path}`
}

const loadTravelBlogs = async () => {
    try {
        const response = await service.getTravelBlogs()
        blogs.value = response.data.map(blog => ({
            ...blog,
            image: blog.image ? getImageUrl(blog.image) : ''
        }))
    } catch (err) {
        console.error(err)
        toast.error('Failed to load travel blogs')
    }
}

const loadContents = async () => {
    try {
        const response = await service.getContents()
        contents.value = response.data
    } catch (err) {
        console.error(err)
    }
}

onMounted(() => { 
    loadContents()
    loadTravelBlogs()
})
</script>

<style scoped>
@keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fadeIn {
    animation: fadeIn 0.2s ease-out;
}

.animate-slideUp {
    animation: slideUp 0.3s ease-out;
}

.custom-scrollbar::-webkit-scrollbar {
    width: 8px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #1E71B8;
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #2a8bb5;
}
</style>