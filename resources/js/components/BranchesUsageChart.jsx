import React, { useEffect, useRef } from "react"

export default function BranchesUsageChart({ data }) {
    const canvasRef = useRef(null)

    useEffect(() => {
        if (!canvasRef.current) return

        const chartData = data.chartData || []

        const colors = [
            "#3B82F6",
            "#10B981",
            "#F59E0B",
            "#EF4444",
            "#8B5CF6",
            "#EC4899",
        ]

        const total = chartData.reduce((sum, item) => sum + item.value, 0)

        const canvas = canvasRef.current
        const ctx = canvas.getContext("2d")

        ctx.clearRect(0, 0, canvas.width, canvas.height)

        let angle = -Math.PI / 2
        const cx = 160
        const cy = 140
        const radius = 100
        const innerRadius = 60

        chartData.forEach((item, index) => {
            const slice = (item.value / total) * 2 * Math.PI
            const color = colors[index % colors.length]

            ctx.beginPath()
            ctx.arc(cx, cy, radius, angle, angle + slice)
            ctx.arc(cx, cy, innerRadius, angle + slice, angle, true)
            ctx.closePath()
            ctx.fillStyle = color
            ctx.fill()

            angle += slice
        })

        ctx.beginPath()
        ctx.arc(cx, cy, innerRadius - 2, 0, Math.PI * 2)
        ctx.fillStyle = "#fff"
        ctx.fill()

        ctx.fillStyle = "#111827"
        ctx.font = "bold 24px system-ui"
        ctx.textAlign = "center"
        ctx.fillText(total, cx, cy - 6)

        ctx.font = "12px system-ui"
        ctx.fillStyle = "#6B7280"
        ctx.fillText("Total Orders", cx, cy + 14)
    }, [data])

    const colors = [
        "#3B82F6",
        "#10B981",
        "#F59E0B",
        "#EF4444",
        "#8B5CF6",
        "#EC4899",
    ]

    return (
        <div className="p-4">
            <h3 className="text-lg font-semibold mb-4">{data.title}</h3>

            <div className="flex flex-col items-center">
                <canvas ref={canvasRef} width="320" height="280" />

                <div className="grid grid-cols-2 gap-3 w-full mt-4">
                    {data.chartData.map((item, idx) => (
                        <div key={idx} className="flex items-center gap-2">
                            <div
                                className="w-3 h-3 rounded-full"
                                style={{ backgroundColor: colors[idx % colors.length] }}
                            />
                            <div>
                                <p className="text-sm font-medium">{item.label}</p>
                                <p className="text-xs text-gray-500">
                                    {item.value} orders
                                </p>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </div>
    )
}
