import React from "react"
import ReactDOM from "react-dom/client"
import BranchesUsageChart from "./components/BranchesUsageChart"

function mountChart() {
    const el = document.getElementById("branches-usage-chart")

    if (!el) return

    const data = JSON.parse(el.dataset.chart)

    ReactDOM.createRoot(el).render(<BranchesUsageChart data={data} />)
}

document.addEventListener("DOMContentLoaded", mountChart)

// 🔥 مهم جداً لـ Filament + Livewire
document.addEventListener("livewire:navigated", mountChart)
document.addEventListener("livewire:update", mountChart)
