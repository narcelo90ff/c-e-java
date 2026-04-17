public class EstudanteRepository
{
private readonly AppDbContext _context = new AppDbContext();
public void Adicionar(Estudante e)
{
_context.Estudantes.Add(e);
_context.SaveChanges();
}
public List<Estudante> Listar()
{
return _context.Estudantes.ToList();
}
public Estudante BuscarPorId(int id)
{
return _context.Estudantes.FirstOrDefault(e => e.Id == id);
}
public void Atualizar(Estudante estudante)
{
var existente = _context.Estudantes.Find(estudante.Id);
if (existente != null)
{
existente.Nome = estudante.Nome;
existente.Idade = estudante.Idade
_context.SaveChanges();
}
}
public void Remover(int id)
{
var estudante = _context.Estudantes.Find(id);
if (estudante != null)
{
_context.Estudantes.Remove(estudante);
_context.SaveChanges();
}
}
}
