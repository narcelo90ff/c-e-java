using System;
using System.Collections.Generic;
using System.Linq;

// --- MODELOS ---
public class Pedido
{
    public int Id { get; set; }
    public DateTime Data { get; set; }
    // Inicializar a lista para evitar NullReferenceException
    public List<ItemPedido> Itens { get; set; } = new List<ItemPedido>();

    // DESAFIO: Método para calcular o total de itens (soma das quantidades)
    public int CalcularTotalDeItens()
    {
        return Itens.Sum(item => item.Quantidade);
    }
}

public class ItemPedido
{
    public int Id { get; set; }
    public string Produto { get; set; }
    public int Quantidade { get; set; }
    public int PedidoId { get; set; }
    public Pedido Pedido { get; set; }
}

// --- REPOSITÓRIO / SERVIÇO ---
public class PedidoService
{
    private List<Pedido> _pedidos = new List<Pedido>();

    // TAREFA: Inserir pedido com itens
    public void AdicionarPedido(Pedido pedido)
    {
        _pedidos.Add(pedido);
    }

    // TAREFA: Listar pedidos com itens
    public List<Pedido> ListarTodos()
    {
        return _pedidos;
    }
}

// --- EXECUÇÃO (MAIN) ---
class Program
{
    static void Main()
    {
        var service = new PedidoService();

        // 1. Criando um novo pedido
        var pedido1 = new Pedido 
        { 
            Id = 1, 
            Data = DateTime.Now 
        };

        // 2. TAREFA: Inserir pedido com itens
        // Adicionando os itens e configurando a referência de volta para o pedido
        pedido1.Itens.Add(new ItemPedido { Id = 10, Produto = "Cerveja Artesanal", Quantidade = 6, Pedido = pedido1 });
        pedido1.Itens.Add(new ItemPedido { Id = 11, Produto = "Carvão 5kg", Quantidade = 2, Pedido = pedido1 });
        pedido1.Itens.Add(new ItemPedido { Id = 12, Produto = "Picanha", Quantidade = 1, Pedido = pedido1 });

        service.AdicionarPedido(pedido1);

        // 3. TAREFA: Listar pedidos com itens
        var todosOsPedidos = service.ListarTodos();

        Console.WriteLine("=== RELATÓRIO DE PEDIDOS ===");
        foreach (var p in todosOsPedidos)
        {
            Console.WriteLine($"Pedido ID: {p.Id} | Data: {p.Data:dd/MM/yyyy HH:mm}");
            Console.WriteLine("Itens do Pedido:");
            
            foreach (var item in p.Itens)
            {
                Console.WriteLine($"  - {item.Produto} (Qtd: {item.Quantidade})");
            }

            // 4. DESAFIO: Exibir o total de itens calculado
            Console.WriteLine($"TOTAL DE ITENS NESTE PEDIDO: {p.CalcularTotalDeItens()}");
            Console.WriteLine(new string('-', 30));
        }
    }
}
