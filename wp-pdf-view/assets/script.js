;(($) => {
  let currentFiles = [];

  $(document).ready(() => {
    console.log("[v0] Folder structure loaded:", window.folderStructure)

    applyGridColumns()
    loadFiles()

    // Main folder change
    $("#main-folder").on("change", function () {
      const mainFolder = $(this).val()
      const subFolderSelect = $("#sub-folder")

      subFolderSelect.html('<option value="">-- All --</option>')

      if (mainFolder && window.folderStructure[mainFolder]) {
        const folderData = window.folderStructure[mainFolder]
        const subfolders = folderData.subfolders || []

        if (Object.keys(subfolders).length > 0) {
          Object.keys(subfolders).forEach((subfolder) => {
            const displayName = subfolders[subfolder]
            subFolderSelect.append($("<option></option>").val(subfolder).text(displayName))
          })
          subFolderSelect.prop("disabled", false)
        } else {
          subFolderSelect.prop("disabled", true)
        }
      } else {
        subFolderSelect.prop("disabled", true)
      }

      loadFiles()
    })

    $("#sub-folder").on("change", () => {
      loadFiles()
    })

    $("#reset-filters").on("click", () => {
      $("#main-folder").val("")
      $("#sub-folder").html('<option value="">-- All --</option>').prop("disabled", true)
      loadFiles()
    })

    $(".pdf-modal").on("click", function (e) {
      if (e.target === this) {
        closeModal()
      }
    })

    $(".pdf-modal-close").on("click", () => {
      closeModal()
    })

    $(".pdf-modal-content").on("click", (e) => {
      e.stopPropagation()
    })

    $(document).on("keydown", (e) => {
      if (e.key === "Escape") {
        closeModal()
      }
    })
  })

  function applyGridColumns() {
    if (window.wpPdfView && window.wpPdfView.gridColumns) {
      const columns = window.wpPdfView.gridColumns
      const style = `
        <style id="mtl-pdf-dynamic-grid">
          .pdf-grid {
            display: grid;
            gap: 24px;
            grid-template-columns: repeat(${columns.mobile}, 1fr);
          }
          
          @media (min-width: 768px) {
            .pdf-grid {
              grid-template-columns: repeat(${columns.tablet}, 1fr);
            }
          }
          
          @media (min-width: 1024px) {
            .pdf-grid {
              grid-template-columns: repeat(${columns.desktop}, 1fr);
            }
          }
        </style>
      `
      $("#mtl-pdf-dynamic-grid").remove()
      $("head").append(style)
    }
  }

  function loadFiles() {
    const mainFolder = $("#main-folder").val()
    const subFolder = $("#sub-folder").val()

    console.log("[v0] Loading files - Main folder:", mainFolder, "Sub folder:", subFolder)

    showLoading()

    $.ajax({
      url: window.wpPdfView.ajaxUrl,
      type: "POST",
      data: {
        action: "get_pdf_files",
        nonce: window.wpPdfView.nonce,
        main_folder: mainFolder,
        sub_folder: subFolder,
      },
      success: (response) => {
        console.log("[v0] AJAX response:", response)

        if (response.success) {
          currentFiles = response.data
          renderFiles(currentFiles)
        } else {
          showError(response.data || "Unable to load file list")
        }
      },
      error: (xhr, status, error) => {
        console.error("[v0] AJAX error:", status, error, xhr.responseText)
        showError("Connection error. Please try again.")
      },
    })
  }

  function renderFiles(files) {
    const grid = $("#pdf-grid")
    grid.empty()

    $(".results-count").text(files.length + " documents")

    if (files.length === 0) {
      grid.html(`
        <div class="no-results">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="m21 21-4.35-4.35"></path>
          </svg>
          <h4>No documents found</h4>
          <p>Please try with different filters</p>
        </div>
      `)
      return
    }

    files.forEach((file) => {
      const card = createFileCard(file)
      grid.append(card)
    })
  }

  function createFileCard(file) {
    const card = $(`
      <div class="pdf-card">
        <div class="pdf-thumbnail" data-pdf-url="${escapeHtml(file.url)}">
          <div class="pdf-thumbnail-placeholder">
            <svg class="pdf-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
              <path d="M14 2v6h6"/>
              <path d="M10 12h4M10 16h4" stroke="white" stroke-width="1.5"/>
            </svg>
          </div>
        </div>
        <div class="pdf-card-body">
          <h4 class="pdf-title">${escapeHtml(file.name)}</h4>
          <div class="pdf-actions">
            <a href="${escapeHtml(file.url)}" download class="pdf-btn-download">
              <svg class="download-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="7 10 12 15 17 10"></polyline>
                <line x1="12" y1="15" x2="12" y2="3"></line>
              </svg>
              Download
            </a>
          </div>
        </div>
      </div>
    `)

    if (file.cover) {
      const img = new Image()
      img.onload = () => {
        card.find(".pdf-thumbnail").html(`<img src="${escapeHtml(file.cover)}" alt="${escapeHtml(file.name)}">`)
      }
      img.onerror = () => {
        console.log("[v0] Failed to load cover image:", file.cover)
      }
      img.src = file.cover
    }

    card.find(".pdf-thumbnail").on("click", function () {
      const pdfUrl = $(this).data("pdf-url")
      openModal(pdfUrl, file.name)
    })

    return card
  }

  function openModal(url, name) {
    $("#pdf-modal-title").text(name)
    $("#pdf-viewer").attr("src", url)
    $("#pdf-modal").addClass("active")
    $("body").css("overflow", "hidden")
  }

  function closeModal() {
    $("#pdf-modal").removeClass("active")
    $("#pdf-viewer").attr("src", "")
    $("body").css("overflow", "")
  }

  function showLoading() {
    $("#pdf-grid").html(`
      <div class="loading-spinner">
        <div class="spinner"></div>
        <p>Loading documents...</p>
      </div>
    `)
    $(".results-count").text("Loading...")
  }

  function showError(message) {
    $("#pdf-grid").html(`
      <div class="no-results">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"></circle>
          <line x1="12" y1="8" x2="12" y2="12"></line>
          <line x1="12" y1="16" x2="12.01" y2="16"></line>
        </svg>
        <h4>An error occurred</h4>
        <p>${escapeHtml(message)}</p>
      </div>
    `)
    $(".results-count").text("0 documents")
  }

  function escapeHtml(text) {
    const map = {
      "&": "&amp;",
      "<": "&lt;",
      ">": "&gt;",
      '"': "&quot;",
      "'": "&#039;",
    }
    return text.replace(/[&<>"']/g, (m) => map[m])
  }
})(window.jQuery)
