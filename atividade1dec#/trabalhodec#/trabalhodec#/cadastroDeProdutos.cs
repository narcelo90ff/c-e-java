using System;
using System.Collections.Generic;
using System.Linq;

// --- MODELO ---
public class Produto
{
    public int Id { get; set; }
    public string Nome { get; set; }
    public double Preco { get; set; }
}

// --- REPOSITÓRIO (CRUD) ---
public class ProdutoRepository
{
    private List<Produto> _produtos = new List<Produto>();

    // CREATE
    public void Inserir(Produto p) => _produtos.Add(p);

    // READ (Listar todos)
    public List<Produto> ListarTodos() => _produtos;

    // READ (Obter por ID)
    public Produto ObterPorId(int id) => _produtos.FirstOrDefault(p => p.Id == id);

    // UPDATE
    public void Atualizar(int id, Produto pAtualizado)
    {
        var existente = ObterPorId(id);
        if (existente != null)
        {
            existente.Nome = pAtualizado.Nome;
            existente.Preco = pAtualizado.Preco;
        }
    }

    // DELETE
    public void Excluir(int id) => _produtos.RemoveAll(p => p.Id == id);
    
    // DESAFIO: Listar produtos acima de um valor mínimo
    public List<Produto> ListarAcimaDe(double precoMinimo) 
        => _produtos.Where(p => p.Preco > precoMinimo).ToList();
}

// --- EXECUÇÃO (MAIN) ---
class Program
{
    static void Main()
    {
        var repo = new ProdutoRepository();

        // TAREFA: Inserir 3 produtos
        repo.Inserir(new Produto { Id = 1, Nome = "Mouse Pad Gamer", Preco = 45.90 });
        repo.Inserir(new Produto { Id = 2, Nome = "Teclado Mecânico", Preco = 280.00 });
        repo.Inserir(new Produto { Id = 3, Nome = "Headset USB", Preco = 150.00 });

        // TAREFA: Listar produtos
        Console.WriteLine("=== Lista de Produtos ===");
        var lista = repo.ListarTodos();
        foreach (var p in lista)
        {
            Console.WriteLine($"ID: {p.Id} | Nome: {p.Nome} | Preço: R$ {p.Preco:F2}");
        }

        // Demonstração do Desafio
        Console.WriteLine("\n=== Produtos Acima de R$ 100,00 ===");
        var caros = repo.ListarAcimaDe(100.00);
        caros.ForEach(p => Console.WriteLine($"- {p.Nome} (R$ {p.Preco:F2})"));
    }
}
