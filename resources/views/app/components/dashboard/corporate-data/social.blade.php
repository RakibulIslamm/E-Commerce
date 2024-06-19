<?php

$socialLinks = [];

// dd($site_settings);

if (isset($site_settings->social_links)) {
    $socialLinks = $site_settings->social_links;
}

?>

<div id="social" class="w-full p-5 bg-white rounded-lg shadow border mt-4">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold pb-2">Social Media Links</h2>
        <button id="social-edit-btn" class="px-5 py-1 border rounded">Edit</button>
    </div>
    <div class="flex flex-col items-start gap-3">
        @if (!empty($socialLinks))
            @foreach ($socialLinks as $name => $url)
                <a href="{{ $url }}" class="flex items-center gap-2">
                    @switch($name)
                        @case('facebook')
                            <x-bxl-facebook-square class="w-5 h-5" />
                        @break

                        @case('twitter')
                            <x-bxl-twitter class="w-5 h-5" />
                        @break

                        @case('instagram')
                            <x-bxl-instagram-alt class="w-5 h-5" />
                        @break

                        @case('linkedin')
                            <x-bxl-linkedin-square class="w-5 h-5" />
                        @break

                        @default
                            {{ null }}
                        @break
                    @endswitch
                    {{ ucfirst($name) }}
                </a>
            @endforeach
        @endif
    </div>
</div>
<div id="edit-social" class="w-full hidden p-5 bg-white rounded-lg shadow border mt-4">
    <h2 class="text-xl font-semibold pb-2">Add Social Media</h2>
    <form id="socialMediaForm" class="w-full" method="POST" action="{{ route('app.corporate-data.update-social') }}">
        @method('PUT')
        @csrf
        <div id="socialLinks" class="space-y-2 w-8/12">
            <!-- Social media link input fields will be dynamically added here -->
            @if (!empty($socialLinks))
                @foreach ($socialLinks as $name => $url)
                    <div class="flex space-x-2">
                        <input type="text" name="socialMediaLinks[{{ $name }}][name]"
                            class="rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 w-4/12"
                            value="{{ $name }}" readonly>
                        <input name="socialMediaLinks[{{ $name }}][url]"
                            class="rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 w-8/12"
                            value="{{ $url }}">
                    </div>
                @endforeach
            @endif
        </div>
        <div class="flex space-x-2 w-9/12 mt-2">
            <select id="socialMediaName" name="socialMediaName"
                class="rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 w-4/12">
                <option value="">Select</option>
                @php
                    $availableOptions = [
                        'facebook' => 'Facebook',
                        'twitter' => 'Twitter',
                        'instagram' => 'Instagram',
                        'linkedin' => 'Linkedin',
                    ];
                    $existingKeys = array_keys($socialLinks);
                @endphp
                @foreach ($availableOptions as $key => $label)
                    @if (!in_array($key, $existingKeys))
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endif
                @endforeach
            </select>
            <input type="url" id="socialMediaUrl"
                class="w-8/12 rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200"
                placeholder="Social Media URL">
            <button type="button" id="addSocialLinkBtn"
                class="px-4 py-2 bg-blue-500 text-white rounded-md">Add</button>
        </div>
        <div class="flex justify-end gap-2 mt-4">
            <button type="button" id="cancel-social-edit"
                class="px-5 py-1 border rounded bg-red-500 text-white">Cancel</button>
            <button type="submit" class="px-5 py-1 border rounded bg-sky-500 text-white">Update</button>
        </div>
    </form>
</div>

<script type="module">
    document.addEventListener("DOMContentLoaded", function() {
        const socialMediaForm = document.getElementById("socialMediaForm");
        const socialLinksContainer = document.getElementById("socialLinks");
        const socialMediaLinks = {}; // Object to store social media links

        document.getElementById("addSocialLinkBtn").addEventListener("click", function() {
            const nameInput = document.getElementById("socialMediaName").value;
            const urlInput = document.getElementById("socialMediaUrl").value;

            if (nameInput && urlInput) {
                const socialLink = document.createElement("div");
                socialLink.className = "flex space-x-2";
                socialLink.innerHTML = `
                <input type="hidden" name="socialMediaLinks[${nameInput}][name]" value="${nameInput}">
                <input type="hidden" name="socialMediaLinks[${nameInput}][url]" value="${urlInput}">
                <input type="text" class="rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 w-4/12" value="${nameInput}" readonly>
                <input type="url" class="rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 w-8/12" value="${urlInput}" readonly>
            `;
                socialLinksContainer.appendChild(socialLink);

                // Add the social media link to the object
                socialMediaLinks[nameInput] = urlInput;

                // Clear the input fields after adding the social link
                document.getElementById("socialMediaUrl").value = "";

                // Reset the select field to the default option
                document.getElementById("socialMediaName").selectedIndex = 0;
            } else {
                alert("Please select a social media platform and provide a URL.");
            }
        });

        socialMediaForm.addEventListener("submit", function(event) {
            // event.preventDefault();
            // Here you can submit the socialMediaLinks object to your server
            // console.log(socialMediaLinks);
        });
    });

    commonUtils.element('social-edit-btn').addEventListener('click', () => {
        commonUtils.toggleVisibility('edit-social', 'social', 'block');
    });

    commonUtils.element('cancel-social-edit').addEventListener('click', () => {
        commonUtils.toggleVisibility('social', 'edit-social', 'block');
    });
</script>
