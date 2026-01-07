export default async function handler(req, res) {
  const BASE = "https://dramabox.sansekai.my.id/api/dramabox";
  const path = (req.query.path || []).join("/");

  const qs = req.url.includes("?") ? req.url.split("?")[1] : "";
  const target = `${BASE}/${path}${qs ? `?${qs}` : ""}`;

  try {
    const r = await fetch(target, {
      method: req.method,
      headers: { accept: "application/json" }
    });

    const data = await r.json();
    return res.status(r.status).json(data);
  } catch (e) {
    return res.status(500).json({ error: e.message });
  }
}
