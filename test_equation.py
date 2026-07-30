import docx
from docx import Document
from docx.oxml import parse_xml

doc = Document()

omml_xml = """<m:oMathPara xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">
  <m:oMath>
    <m:r><m:t>= </m:t></m:r>
    <m:rad>
      <m:radPr><m:degHide m:val="1"/></m:radPr>
      <m:deg/>
      <m:e>
        <m:r><m:t>(83 - 76)</m:t></m:r>
        <m:sSup>
          <m:e><m:r><m:t></m:t></m:r></m:e>
          <m:sup><m:r><m:t>2</m:t></m:r></m:sup>
        </m:sSup>
        <m:r><m:t> + (81 - 84)</m:t></m:r>
        <m:sSup>
          <m:e><m:r><m:t></m:t></m:r></m:e>
          <m:sup><m:r><m:t>2</m:t></m:r></m:sup>
        </m:sSup>
      </m:e>
    </m:rad>
  </m:oMath>
</m:oMathPara>"""

p = doc.add_paragraph()
p._p.append(parse_xml(omml_xml))

doc.save("f:/Laragon/skripsi_yu/test_equation.docx")
print("Saved test equation successfully!")
