<!DOCTYPE html>
<html lang="ca">

<head>
	<meta charset="UTF-8">
	<title>Codi del teu encarrec</title>
</head>

<body style="margin:0;padding:0;background:#f3f4f6;font-family:Arial,sans-serif;color:#0f172a;">
	<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="padding:24px 0;">
		<tr>
			<td align="center">
				<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:520px;background:#ffffff;border-radius:12px;overflow:hidden;">
					<tr>
						<td style="background:#0f5f7f;color:#ffffff;padding:16px 20px;font-size:18px;font-weight:700;">
							Farmacia Soler
						</td>
					</tr>
					<tr>
						<td style="padding:20px;">
							<p style="margin:0 0 10px;font-size:15px;line-height:1.5;">Aquest es el codi del teu encarrec:</p>
							<div style="display:inline-block;background:#e0f2fe;color:#0c4a6e;padding:10px 14px;border-radius:8px;font-size:22px;font-weight:700;letter-spacing:1px;">
								{{ $code }}
							</div>
							<p style="margin:14px 0 0;font-size:13px;color:#64748b;">Guarda aquest codi per consultar l'estat del teu encarrec.</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>

</html>