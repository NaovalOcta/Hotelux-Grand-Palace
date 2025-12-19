// === LOGIKA SCROLL RESET (TAMBAHKAN DI PALING ATAS) ===
if (history.scrollRestoration) {
    history.scrollRestoration = "manual"; // Mencegah browser mengingat posisi scroll lama
}

window.onbeforeunload = function () {
    window.scrollTo(0, 0); // Paksa scroll ke 0,0 saat halaman mau ditutup/refresh
};
// =======================================================

// === PENTING! GANTI DENGAN KREDENSIAL SUPABASE ANDA ===
const SUPABASE_URL = "https://xdmrhxrztxyqpfzfzxxd.supabase.co"; // Ganti dengan Project URL Anda
const SUPABASE_KEY =
    "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InhkbXJoeHJ6dHh5cXBmemZ6eHhkIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NjEyNzg3MTEsImV4cCI6MjA3Njg1NDcxMX0.HzciPuYyYLTjLG-Uu65tCnnGpPTZlpem3UiHD71CMzs"; // Ganti dengan anon public key Anda
// =======================================================

import { hideSplashScreen } from "./splash.js";
console.log("app.js started"); // Log awal

// Variabel global untuk menyimpan data dari API
let hotelProfile = null;
let roomTypes = [];
let facilities = [];
let promotions = [];
let testimonials = [];

// Inisialisasi Klien Supabase
let supabaseClient;
try {
    if (typeof supabase === "undefined" || !supabase.createClient) {
        throw new Error(
            "Supabase library not loaded correctly. Check the script tag in HTML."
        );
    }
    supabaseClient = supabase.createClient(SUPABASE_URL, SUPABASE_KEY);
    console.log("Supabase client initialized successfully.");
} catch (error) {
    console.error("Supabase client initialization failed:", error);
    document.body.insertAdjacentHTML(
        "afterbegin",
        `<p style="background-color: red; color: white; padding: 10px; text-align: center; position: fixed; top:0; left:0; width: 100%; z-index: 9999;">Error initializing application: ${error.message}</p>`
    );
}

// === HELPER FUNCTIONS ===

/**
 * Membersihkan URL gambar dari karakter tidak valid []() dan spasi ekstra.
 * Juga menangani format markdown link [text](url).
 * @param {string} urlString URL yang mungkin kotor
 * @returns {string} URL bersih atau string kosong
 */
function cleanImageUrl(urlString) {
    if (typeof urlString !== "string") return "";
    // Cek format markdown link [text](url)
    const markdownMatch = urlString.match(/\((.*?)\)/);
    if (markdownMatch && markdownMatch[1]) {
        return markdownMatch[1].trim(); // Ambil konten di dalam ()
    }
    // Jika bukan format markdown, bersihkan kurung biasa dan spasi
    return urlString.replace(/[\[\]()]/g, "").trim();
}

/**
 * Format mata uang ke Rupiah
 * @param {number} amount Jumlah angka
 * @returns {string} String mata uang terformat atau 'N/A'
 */
function formatCurrency(amount) {
    if (typeof amount !== "number" || isNaN(amount)) {
        return "N/A";
    }
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(amount);
}

/**
 * Membuat gambar placeholder
 * @param {number} width Lebar
 * @param {number} height Tinggi
 * @param {string} text Teks placeholder
 * @returns {string} URL gambar placeholder
 */
function placeholderImage(width = 400, height = 225, text = "Image") {
    return `https://placehold.co/${width}x${height}/e2e8f0/cccccc?text=${encodeURIComponent(
        text
    )}`;
}

// === FUNGSI NOTIFIKASI MODAL PREMIUM ===
function showNotification(type, title, message) {
    const modal = document.getElementById("notification-modal");
    const backdrop = document.getElementById("modal-backdrop");
    const panel = document.getElementById("modal-panel");
    const modalTitle = document.getElementById("modal-title");
    const modalMessage = document.getElementById("modal-message");
    const modalIcon = document.getElementById("modal-icon");
    const modalIconBg = document.getElementById("modal-icon-bg");
    const closeBtn = document.getElementById("modal-close-btn");

    if (!modal) return;

    // 1. Set Konten & Styling Berdasarkan Tipe
    modalTitle.textContent = title;
    modalMessage.innerHTML = message; // innerHTML agar bisa render <b> atau <br>

    if (type === "success") {
        // Style Sukses (Cyan/Green Theme)
        modalIcon.className = "ri-checkbox-circle-line text-3xl text-cyan-400";
        modalIconBg.className =
            "mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-cyan-900/50 sm:mx-0 sm:h-12 sm:w-12 border border-cyan-500/30";
        closeBtn.className =
            "inline-flex w-full justify-center rounded-full bg-cyan-500 px-6 py-2 text-sm font-semibold text-gray-900 shadow-sm hover:bg-cyan-400 sm:ml-3 sm:w-auto transition-colors duration-300";
        closeBtn.textContent = "Excellent!";
    } else {
        // Style Error (Red Theme)
        modalIcon.className = "ri-error-warning-line text-3xl text-red-400";
        modalIconBg.className =
            "mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-900/50 sm:mx-0 sm:h-12 sm:w-12 border border-red-500/30";
        closeBtn.className =
            "inline-flex w-full justify-center rounded-full bg-red-500 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-600 sm:ml-3 sm:w-auto transition-colors duration-300";
        closeBtn.textContent = "Try Again";
    }

    // 2. Tampilkan Modal (Remove hidden class)
    modal.classList.remove("hidden");

    // 3. Trigger Animasi Masuk (Gunakan setTimeout kecil agar transisi CSS jalan)
    setTimeout(() => {
        backdrop.classList.add("backdrop-show");
        panel.classList.remove("opacity-0", "scale-95");
        panel.classList.add("modal-show");
    }, 10);

    // 4. Event Listener Tutup
    const closeModal = () => {
        backdrop.classList.remove("backdrop-show");
        panel.classList.remove("modal-show");
        panel.classList.add("opacity-0", "scale-95");

        // Tunggu animasi selesai baru hide element
        setTimeout(() => {
            modal.classList.add("hidden");
        }, 300);

        // Bersihkan event listener agar tidak menumpuk
        closeBtn.removeEventListener("click", closeModal);
    };

    closeBtn.addEventListener("click", closeModal);
}

// === FUNGSI PENGAMBIL DATA (FETCH API) ===
async function fetchHotelProfile() {
    if (!supabaseClient) return null;
    console.log("Fetching hotel profile...");
    // Ambil semua kolom, termasuk kolom baru hero_image_url
    const { data, error } = await supabaseClient
        .from("hotelProfile")
        .select("*")
        .single();
    if (error) {
        console.error("Error fetching hotel profile:", error.message);
        return null;
    }
    console.log("Hotel Profile data fetched (raw):", data);
    return data;
}
async function fetchRoomTypes() {
    if (!supabaseClient) return [];
    console.log("Fetching room types...");
    const { data, error } = await supabaseClient.from("roomTypes").select("*");
    if (error) {
        console.error("Error fetching room types:", error.message);
        return [];
    }
    console.log("Room Types data fetched:", data);
    return data;
}
async function fetchFacilities() {
    if (!supabaseClient) return [];
    console.log("Fetching facilities...");
    const { data, error } = await supabaseClient
        .from("hotelFacilities")
        .select("*");
    if (error) {
        console.error("Error fetching facilities:", error.message);
        return [];
    }
    console.log("Facilities data fetched:", data);
    return data;
}
async function fetchPromotions() {
    if (!supabaseClient) return [];
    console.log("Fetching promotions...");
    const { data, error } = await supabaseClient.from("promotions").select("*");
    if (error) {
        console.error("Error fetching promotions:", error.message);
        return [];
    }
    console.log("Promotions data fetched:", data);
    return data;
}
async function fetchTestimonials() {
    if (!supabaseClient) return [];
    console.log("Fetching testimonials...");
    const { data, error } = await supabaseClient
        .from("testimonials")
        .select("*");
    if (error) {
        console.error("Error fetching testimonials:", error.message);
        return [];
    }
    console.log("Testimonials data fetched:", data);
    return data;
}

// === FUNGSI UTAMA UNTUK MEMUAT SEMUA DATA ===
async function loadAllData() {
    if (!supabaseClient) {
        console.warn("Supabase client not available, skipping data load.");
        return;
    }
    console.log("Loading all data from Supabase...");
    const loadingIndicator = document.getElementById("loading-indicator");
    if (loadingIndicator) loadingIndicator.classList.remove("hidden");

    try {
        const [
            profileData,
            roomsData,
            facilitiesData,
            promotionsData,
            testimonialsData,
        ] = await Promise.all([
            fetchHotelProfile(),
            fetchRoomTypes(),
            fetchFacilities(),
            fetchPromotions(),
            fetchTestimonials(),
        ]);

        hotelProfile = profileData;
        roomTypes = roomsData;
        facilities = facilitiesData;
        promotions = promotionsData;
        testimonials = testimonialsData;

        console.log("All data loaded successfully!");
        renderDataToHTML(); // Panggil fungsi render
    } catch (error) {
        console.error("Failed to load all data:", error);
        // Tampilkan pesan error jika perlu
        const splash = document.getElementById("splash-screen");
        if (splash)
            splash.innerHTML = `<p class="text-red-500">Error loading data. Please refresh.</p>`;
    } finally {
        // Sembunyikan loading setelah penundaan singkat agar konten sempat render
        setTimeout(() => {
            hideSplashScreen();
            console.log("Splash screen hidden.");
        }, 1000); // Delay 1 detik agar terlihat "mahal"

        console.log("Finished loading data attempt.");
    }
}

// === FUNGSI RENDER UTAMA ===
function renderDataToHTML() {
    console.log("Rendering data into HTML...");
    console.log("Current hotelProfile data:", hotelProfile); // Log data profil saat render

    // Render Profil Hotel
    if (hotelProfile) {
        document.title = hotelProfile.name || "Hotelux"; // Set judul halaman
        // Nama Hotel (di beberapa tempat)
        document
            .querySelectorAll(".hotel-name")
            .forEach((el) => (el.textContent = hotelProfile.name || "Hotelux"));

        // Tagline Hero
        const taglineEl = document.getElementById("hero-tagline");
        if (taglineEl) taglineEl.textContent = hotelProfile.tagline || "";

        // --- MODIFIKASI HANYA PADA BAGIAN HERO IMAGE ---
        const heroImgEl = document.getElementById("hero-image");
        if (heroImgEl) {
            // Langsung akses kolom hero_image_url (tipe text)
            const rawUrl = hotelProfile.hero_image;
            console.log("Raw Hero URL (text) from DB:", rawUrl); // Log URL mentah

            if (rawUrl && typeof rawUrl === "string") {
                const cleanUrl = cleanImageUrl(rawUrl); // Tetap bersihkan URL
                console.log("Cleaned Hero URL:", cleanUrl);

                if (cleanUrl) {
                    heroImgEl.src = cleanUrl;
                    // Ambil alt text dari kolom lain jika ada, atau gunakan nama hotel
                    heroImgEl.alt =
                        hotelProfile.tagline ||
                        hotelProfile.name ||
                        "Hero Image"; // Contoh: pakai tagline
                    console.log("Set heroImgEl.src to:", heroImgEl.src);

                    heroImgEl.onerror = function () {
                        console.error(
                            "Error loading hero image from src:",
                            heroImgEl.src
                        );
                        this.onerror = null; // Mencegah loop error jika placeholder juga gagal
                        this.src = placeholderImage(
                            1920,
                            1080,
                            "Image Load Error"
                        );
                    };
                } else {
                    console.warn(
                        "Cleaned Hero URL is empty. Setting placeholder."
                    );
                    heroImgEl.src = placeholderImage(
                        1920,
                        1080,
                        "Invalid URL Data"
                    );
                    heroImgEl.alt = "Invalid image URL provided";
                }
            } else {
                console.warn(
                    "Hero image URL data missing or not a string in 'hero_image_url' column. Setting placeholder."
                );
                heroImgEl.src = placeholderImage(
                    1920,
                    1080,
                    "Hero Image Data Missing"
                );
                heroImgEl.alt = "Hero image not available";
            }
        } else {
            console.error(
                "!!! Element with ID 'hero-image' NOT FOUND in HTML !!!"
            );
        }
        // --- AKHIR MODIFIKASI HERO IMAGE ---

        // Deskripsi About
        const aboutDescEl = document.getElementById("about-description");
        if (aboutDescEl)
            aboutDescEl.innerHTML =
                hotelProfile.description_long || "Loading description...";

        // Key Highlights (Perbaiki HTML generation + Ikon)
        const highlightsContainer = document.getElementById(
            "key-highlights-list"
        );
        if (
            highlightsContainer &&
            hotelProfile.key_highlights &&
            hotelProfile.key_highlights.length > 0
        ) {
            highlightsContainer.innerHTML = hotelProfile.key_highlights
                .map(
                    (item) => `
            <div class="highlight-item flex items-start space-x-3 bg-gray-700 p-4 rounded-lg shadow"> <!-- Sesuaikan class -->
                <span class="material-icons-outlined text-cyan-400 mt-1">${
                    item.icon || "star"
                }</span>
                 <div>
                    <h4 class="font-semibold text-white">${
                        item.title || "Highlight"
                    }</h4>
                    <p class="text-gray-400 text-sm">${
                        item.description || ""
                    }</p>
                 </div>
            </div>
         `
                )
                .join("");
        } else if (highlightsContainer) {
            highlightsContainer.innerHTML =
                '<p class="text-gray-500 italic col-span-full">No highlights available.</p>';
        }

        // Footer Address
        const footerAddressEl = document.getElementById("footer-address");
        if (footerAddressEl)
            footerAddressEl.textContent = `${
                hotelProfile.address?.street || ""
            }, ${hotelProfile.address?.city || ""}, ${
                hotelProfile.address?.zip_code || ""
            }`;
        // Footer Contact
        const footerContactEl = document.getElementById("footer-contact");
        if (footerContactEl)
            footerContactEl.innerHTML = `
        <p><a href="mailto:${
            hotelProfile.contact?.email_general || "#"
        }" class="hover:text-cyan-400">${
                hotelProfile.contact?.email_general || "-"
            }</a></p>
        <p><a href="tel:${
            hotelProfile.contact?.phone || "#"
        }" class="hover:text-cyan-400">${
                hotelProfile.contact?.phone || "-"
            }</a></p>`;
        // Footer Social Links (Perbaiki HTML + URL)
        const footerSocialEl = document.getElementById("footer-social-links");
        if (footerSocialEl && hotelProfile.social_links) {
            footerSocialEl.innerHTML = `
            <h5 class="font-semibold text-white mb-4 uppercase text-sm tracking-wider">Follow Us</h5>
            <div class="flex space-x-4">
              <a href="${
                  cleanImageUrl(hotelProfile.social_links.facebook) || "#"
              }" target="_blank" rel="noopener noreferrer" class="hover:text-cyan-400"><i class="ri-facebook-fill text-xl"></i></a>
              <a href="${
                  cleanImageUrl(hotelProfile.social_links.instagram) || "#"
              }" target="_blank" rel="noopener noreferrer" class="hover:text-cyan-400"><i class="ri-instagram-line text-xl"></i></a>
              <a href="${
                  cleanImageUrl(hotelProfile.social_links.twitter) || "#"
              }" target="_blank" rel="noopener noreferrer" class="hover:text-cyan-400"><i class="ri-twitter-fill text-xl"></i></a>
            </div>
          `;
        }
        // Footer Logo (Nama Hotel)
        const footerLogoEl = document.getElementById("footer-logo");
        if (footerLogoEl)
            footerLogoEl.textContent = hotelProfile.name || "Hotelux";
    } else {
        console.warn("Hotel profile data is missing during render.");
        // Tampilkan pesan error atau biarkan placeholder
    }

    // Render Rooms (Perbaiki URL + Fallback + Struktur Card)
    const roomsContainer = document.getElementById("rooms-container");
    if (roomsContainer && roomTypes && roomTypes.length > 0) {
        roomsContainer.innerHTML = roomTypes
            .map((room) => {
                const imageUrl =
                    room.gallery_images && room.gallery_images.length > 0
                        ? cleanImageUrl(room.gallery_images[0])
                        : "";
                const price =
                    room.rate_plans && room.rate_plans.length > 0
                        ? room.rate_plans[0].price_per_night
                        : 0;
                return `
            <div class="room-card bg-gray-800 rounded-lg shadow-lg overflow-hidden flex flex-col"> <!-- Pastikan flex flex-col -->
                <img src="${
                    imageUrl || placeholderImage(400, 224, room.name || "Room")
                }"
                     alt="${room.name || "Room image"}"
                     class="w-full h-56 object-cover"
                     onerror="this.onerror=null; this.src='${placeholderImage(
                         400,
                         224,
                         "Image Error"
                     )}';"> <!-- Fallback jika load error -->
                <div class="p-6 flex flex-col flex-grow"> <!-- flex-grow penting -->
                    <h3 class="text-xl font-semibold text-white mb-2">${
                        room.name || "Room Name"
                    }</h3>
                    <p class="text-gray-400 leading-relaxed mb-4 flex-grow line-clamp-3">${
                        room.description || "No description available."
                    }</p> <!-- flex-grow penting -->
                    <div class="flex justify-between items-center mb-4 text-sm text-gray-400">
                      <span><i class="ri-user-line mr-1 align-middle"></i> Max ${
                          room.occupancy?.max_adults || "?"
                      } Adults</span>
                      <span><i class="ri-ruler-line mr-1 align-middle"></i> ${
                          room.size_m2 || "?"
                      } m²</span>
                    </div>
                    <div class="text-right mt-auto"> <!-- mt-auto penting -->
                      <span class="text-sm text-gray-500">Starts from</span>
                      <p class="text-xl font-bold text-cyan-400">${formatCurrency(
                          price
                      )}/night</p>
                    </div>
                </div>
            </div>
          `;
            })
            .join("");
    } else if (roomsContainer) {
        roomsContainer.innerHTML =
            '<p class="text-gray-500 italic col-span-full text-center">No rooms available.</p>';
    }

    // Render Facilities (Perbaiki Struktur HTML + Ikon)
    const facilitiesContainer = document.getElementById("facilities-container");
    if (facilitiesContainer && facilities && facilities.length > 0) {
        facilitiesContainer.innerHTML = facilities
            .map(
                (category) => `
          <div class="facility-category mb-8"> <!-- Jarak antar kategori -->
              <h3 class="text-2xl font-semibold text-white mb-4">${
                  category.category || "Category"
              }</h3>
              <div class="grid grid-cols-2 md:grid-cols-4 gap-x-6 gap-y-4 bg-gray-700 p-6 rounded-lg shadow"> <!-- Latar belakang + grid -->
                  ${
                      category.items && Array.isArray(category.items)
                          ? category.items
                                .map(
                                    (item) => `
                      <div class="flex items-center space-x-2 text-gray-300 px-2">
                          <span class="material-icons-outlined text-cyan-400 text-lg">${
                              item.icon || "star"
                          }</span>
                          <span>${item.name || "Facility"}</span>
                      </div>
                  `
                                )
                                .join("")
                          : '<p class="col-span-full text-gray-500 italic">No items in this category.</p>'
                  }
              </div>
          </div>
      `
            )
            .join("");
    } else if (facilitiesContainer) {
        facilitiesContainer.innerHTML =
            '<p class="text-gray-500 italic text-center">No facilities information available.</p>';
    }

    // Render Promotions (Perbaiki URL + Fallback + Struktur Card)
    const promotionsContainer = document.getElementById("promotions-container");
    if (promotionsContainer && promotions && promotions.length > 0) {
        promotionsContainer.innerHTML = promotions
            .map((promo) => {
                const imageUrl = cleanImageUrl(promo.image_url);
                return `
            <div class="promo-card bg-gray-800 rounded-lg shadow-lg overflow-hidden md:flex"> <!-- flex on medium screens -->
                <img src="${
                    imageUrl ||
                    placeholderImage(300, 200, promo.title || "Promo")
                }"
                     alt="${promo.title || "Promotion image"}"
                     class="w-full md:w-1/3 h-48 md:h-auto object-cover"
                     onerror="this.onerror=null; this.src='${placeholderImage(
                         300,
                         200,
                         "Image Error"
                     )}';">
                <div class="p-6 flex flex-col justify-center md:w-2/3">
                  <h3 class="text-xl font-semibold text-white mb-2">${
                      promo.title || "Special Offer"
                  }</h3>
                  <p class="text-gray-400 mb-4 text-sm leading-relaxed">${
                      promo.description || ""
                  }</p>
                  <span class="text-sm font-medium text-cyan-400">Use Code: <strong class="bg-gray-700 px-2 py-1 rounded text-cyan-300">${
                      promo.promo_code || "N/A"
                  }</strong></span>
                </div>
            </div>
           `;
            })
            .join("");
    } else if (promotionsContainer) {
        promotionsContainer.innerHTML =
            '<p class="text-gray-500 italic col-span-full text-center">No current promotions.</p>';
    }

    // Render Testimonials (Perbaiki Struktur Card + Rating Stars)
    const testimonialsContainer = document.getElementById(
        "testimonials-container"
    );
    if (testimonialsContainer && testimonials && testimonials.length > 0) {
        testimonialsContainer.innerHTML = testimonials
            .map(
                (t) => `
         <div class="testimonial-card bg-gray-800 p-6 rounded-lg shadow-lg flex flex-col"> <!-- flex -->
             <div class="flex items-center mb-4">
               <div class="bg-cyan-500 text-gray-900 rounded-full w-10 h-10 flex items-center justify-center text-lg font-bold">
                 ${t.name ? t.name.charAt(0).toUpperCase() : "?"}
               </div>
               <div class="ml-3">
                 <p class="font-semibold text-white">${t.name || "Guest"}</p>
                 <p class="text-sm text-gray-500">${
                     t.origin || "Unknown Location"
                 }</p>
               </div>
             </div>
             <p class="text-gray-400 italic mb-4 flex-grow">"${
                 t.quote || "No comment provided."
             }"</p> <!-- flex-grow -->
             <div class="flex mt-auto"> <!-- Rating stars -->
               ${[...Array(5)]
                   .map(
                       (_, i) => `
                 <span class="material-icons-outlined text-sm ${
                     i < (t.rating || 0) ? "text-yellow-400" : "text-gray-600"
                 }">
                   ${i < (t.rating || 0) ? "star" : "star_border"}
                 </span>
               `
                   )
                   .join("")}
             </div>
         </div>
     `
            )
            .join("");
    } else if (testimonialsContainer) {
        testimonialsContainer.innerHTML =
            '<p class="text-gray-500 italic col-span-full text-center">No testimonials yet.</p>';
    }

    // Isi dropdown booking
    const bookingSelect = document.getElementById("booking-room-select");
    if (bookingSelect && roomTypes && roomTypes.length > 0) {
        const currentValue = bookingSelect.value;
        bookingSelect.innerHTML =
            '<option value="">-- Select a Room Type --</option>'; // Placeholder lebih baik
        roomTypes.forEach((room) => {
            if (room.rate_plans && room.rate_plans.length > 0) {
                const option = document.createElement("option");
                option.value = room.id;
                const price = room.rate_plans[0].price_per_night;
                option.textContent = `${
                    room.name || "Unnamed Room"
                } (${formatCurrency(price)}/night)`;
                option.dataset.price = price;
                if (room.id === currentValue) {
                    option.selected = true;
                }
                bookingSelect.appendChild(option);
            }
        });
        if (currentValue) {
            bookingSelect.dispatchEvent(new Event("change"));
        }
    } else if (bookingSelect) {
        bookingSelect.innerHTML =
            '<option value="">-- No rooms available to book --</option>';
    }

    console.log("Finished rendering attempts.");
}

// === LOGIKA BOOKING ===
function calculateBookingPrice() {
    const roomSelect = document.getElementById("booking-room-select");
    const checkInInput = document.getElementById("check-in");
    const checkOutInput = document.getElementById("check-out");
    const priceInput = document.getElementById("total-price");

    if (!roomSelect || !checkInInput || !checkOutInput || !priceInput) {
        return;
    }

    const selectedOption = roomSelect.options[roomSelect.selectedIndex];
    if (
        !selectedOption ||
        !selectedOption.dataset.price ||
        selectedOption.value === ""
    ) {
        priceInput.value = "";
        return;
    }
    const pricePerNight = parseFloat(selectedOption.dataset.price);

    const checkInValue = checkInInput.value;
    const checkOutValue = checkOutInput.value;
    if (!checkInValue || !checkOutValue) {
        priceInput.value = "";
        return;
    }

    try {
        // Tambah try-catch untuk tanggal invalid
        const checkInDate = new Date(checkInValue);
        const checkOutDate = new Date(checkOutValue);

        // Cek tanggal valid dan check-out setelah check-in
        if (
            isNaN(checkInDate.getTime()) ||
            isNaN(checkOutDate.getTime()) ||
            checkOutDate <= checkInDate
        ) {
            priceInput.value = "";
            return;
        }

        const timeDiff = checkOutDate.getTime() - checkInDate.getTime();
        const nights = Math.ceil(timeDiff / (1000 * 3600 * 24));

        if (!isNaN(pricePerNight) && nights > 0) {
            priceInput.value = nights * pricePerNight;
        } else {
            priceInput.value = "";
        }
    } catch (e) {
        console.error("Error parsing dates:", e);
        priceInput.value = ""; // Kosongkan jika error
    }
}

const bookingForm = document.getElementById("booking-form");
const bookingMessage = document.getElementById("booking-message");
const bookingSubmitBtn = document.getElementById("booking-submit-btn");
const roomSelectElement = document.getElementById("booking-room-select");
const checkInElement = document.getElementById("check-in");
const checkOutElement = document.getElementById("check-out");
const priceInputElement = document.getElementById("total-price");

if (roomSelectElement)
    roomSelectElement.addEventListener("change", calculateBookingPrice);
if (checkInElement)
    checkInElement.addEventListener("change", calculateBookingPrice);
if (checkOutElement)
    checkOutElement.addEventListener("change", calculateBookingPrice);

if (bookingForm) {
    bookingForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        if (!supabaseClient || !bookingSubmitBtn) return;

        // 1. Ubah status tombol
        bookingSubmitBtn.disabled = true;
        bookingSubmitBtn.textContent = "Processing...";

        // 2. Ambil Data Form TERLEBIH DAHULU
        const formData = new FormData(bookingForm);
        const bookingData = {
            guest_name: formData.get("guest_name")?.trim(),
            guest_email: formData.get("guest_email")?.trim(),
            room_id: formData.get("room_id"),
            check_in: formData.get("check_in"),
            check_out: formData.get("check_out"),
            total_price: parseFloat(formData.get("total_price") || "0"),
        };

        // 3. Lakukan Validasi
        let errors = [];
        if (!bookingData.guest_name) errors.push("Full Name is required.");
        if (
            !bookingData.guest_email ||
            !/\S+@\S+\.\S+/.test(bookingData.guest_email)
        )
            errors.push("Valid Email is required.");
        if (!bookingData.room_id) errors.push("Room Type is required.");
        if (!bookingData.check_in) errors.push("Check-in Date is required.");
        if (!bookingData.check_out) errors.push("Check-out Date is required.");
        if (
            bookingData.check_in &&
            bookingData.check_out &&
            new Date(bookingData.check_out) <= new Date(bookingData.check_in)
        )
            errors.push("Check-out date must be after check-in date.");
        if (!bookingData.total_price || bookingData.total_price <= 0)
            errors.push(
                "Total price seems invalid. Please re-select dates or room."
            );

        // 4. Cek Error (SETELAH validasi selesai)
        if (errors.length > 0) {
            // Gunakan Modal Premium untuk Error Validasi
            showNotification(
                "error",
                "Booking Incomplete",
                `<ul class="list-disc pl-4 text-left space-y-1 text-sm">${errors
                    .map((err) => `<li>${err}</li>`)
                    .join("")}</ul>`
            );

            // Reset tombol
            bookingSubmitBtn.disabled = false;
            bookingSubmitBtn.textContent = "Submit Booking";
            return; // Berhenti di sini, jangan kirim ke Supabase
        }

        // 5. Kirim data ke Supabase (Jika tidak ada error)
        console.log("Submitting booking:", bookingData);
        const { data, error } = await supabaseClient
            .from("bookings")
            .insert([bookingData])
            .select();

        if (error) {
            console.error("Error creating booking:", error);
            // Gunakan Modal Premium untuk Error Supabase
            showNotification(
                "error",
                "Something Went Wrong",
                `We couldn't process your booking. <br><span class="text-xs opacity-70">Error: ${error.message}</span>`
            );
        } else {
            console.log("Booking successful:", data);
            // Gunakan Modal Premium untuk Sukses
            showNotification(
                "success",
                "Booking Confirmed!",
                `Thank you, <b>${bookingData.guest_name}</b>. <br>We have received your reservation. A confirmation email will be sent to <u>${bookingData.guest_email}</u> shortly.`
            );

            bookingForm.reset();
            if (priceInputElement) priceInputElement.value = ""; // Kosongkan harga
        }

        // 6. Reset tombol akhir
        bookingSubmitBtn.disabled = false;
        bookingSubmitBtn.textContent = "Submit Booking";
    });
} else {
    console.warn(
        "Booking form with id 'booking-form' not found. Booking functionality disabled."
    );
}

// === INISIALISASI APLIKASI ===
console.log("Adding DOMContentLoaded listener.");
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", loadAllData);
} else {
    // DOM sudah siap, langsung panggil
    console.log("DOM already loaded, calling loadAllData directly.");
    loadAllData();
}
console.log("app.js finished initial execution.");
